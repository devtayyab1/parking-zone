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
                Emails Templates
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
                      @can('user_auth', ["add"])  
                        <a style="float: right; margin-bottom: 9px;" class="btn btn-success"
                           href="{{ route("emails.create") }}"> Add New</a>
     @endcan
                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                            <tr>

                                <th> Title</th>
                                <th> Subject</th>


                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emails as $email)
                                <tr>


                                    <td class="hidden-480">{{ $email->title }}</td>
                                    <td class="hidden-480">{{ $email->subject }}</td>


                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">

 @can('user_auth', ["delete"])
                                            <form method="POST" style="margin-right: 5px; float: left"
                                                  onsubmit="return confirm('Are you sure?')"
                                                  action="{{ route('emails.destroy', $email->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-xs btn-danger">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </button>
                                            </form>
     @endcan

                                            </a>
 @can('user_auth', ["edit"])
                                            <a href="{{ route('emails.edit',$email->id) }}">
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

                        {{ $emails->links("vendor.pagination.default") }}
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
