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
                Discounts
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

                                <th>Type</th>
                                <th>Discount for</th>
                                <th>Promo</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Discount Value</th>
                                <th>Used at Quote</th>
                                <th>Used when Confirm</th>
                                <th>Status</th>
                                <th></th>


                            </tr>
                            </thead>

                            <tbody>
                            @foreach($discounts as $discount)
                                <tr>


                                    <td class="hidden-480">{{ $discount->discount_type }}</td>
                                    <td class="hidden-480">{{ $discount->discount_for }}</td>
                                    <td class="hidden-480">{{ $discount->promo }}</td>
                                    <td class="hidden-480">{{ $discount->start_date }}</td>
                                    <td class="hidden-480">{{ $discount->end_date }}</td>
                                    <td class="hidden-480">{{ $discount->discount_value }}</td>
                                    <td class="hidden-480"></td>
                                    <td class="hidden-480"></td>
                                    <td class="hidden-480">{{ $discount->status }}</td>


                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">

      @can('user_auth', ["delete"])
                                            <form method="POST" style="margin-right: 5px; float: left"
                                                  onsubmit="return confirm('Are you sure?')"
                                                  action="{{ route('discounts.destroy', [$discount->id]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-xs btn-danger">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </button>
                                            </form>
                                                      @endcan
                     @can('user_auth', ["edit"])

                                            <a href="{{ route("discounts.edit",[$discount->id]) }}">
                                                <button class="btn btn-xs btn-info">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </button>
                                            </a>
                                            @endcan


                                            </a>



                                        </div>


                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $discounts->links("vendor.pagination.default") }}
                    </div><!-- /.span -->
                </div><!-- /.row -->


                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    @endsection
