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
                Reviews
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
                        {{--<a style="float: right; margin-bottom: 9px;" class="btn btn-success"--}}
                           {{--href="{{ route("pages.create") }}"> Add New</a>--}}

                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Airport</th>
                                <th>Admin</th>
                                <th>Company</th>

                                <th>Rating</th>
                                <th>Date</th>
                                <th>Resend Link</th>
                                <th>Google</th>
                                <th>Email</th>
                                <th>Status</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($reviews as $review)
                                <tr>


                                    <td class="hidden-480">{{ $review->username }}</td>
                                    <td class="hidden-480">@if($review->airport) {{ $review->airport->name }} @endif</td>
                                    <td class="hidden-480">@if($review->user) {{ $review->user->name }} @endif</td>
                                    <td class="hidden-480">@if($review->company) {{ $review->company->name }} @endif</td>
                                    <td class="hidden-480">{{ $review->rating }}</td>
                                    <td class="hidden-480">{{ $review->created_at }}</td>
                                    <td class="hidden-480"><a href="">Resend Link</a> </td>
                                    <td class="hidden-480">{{ $review->google_count }}</td>

                                    <td class="hidden-480">{{ $review->email }}</td>

                                    <td class="hidden-480">@if($review->status=="Yes") {{ "Active"  }} @else {{ "Inactive" }} @endif</td>



                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $reviews->links("vendor.pagination.default") }}
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
