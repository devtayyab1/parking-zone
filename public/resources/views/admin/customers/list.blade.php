@extends('admin.layout.master')
@section('stylesheets')
    @parent
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/jquery-ui.custom.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/chosen.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/admin.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-timepicker.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/daterangepicker.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href=" {{ secure_asset('assets/css/bootstrap-colorpicker.min.css') }}"/>
@endsection
@section('content')
<style>

    /*
    Label the data
    */
   
    @media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
     td:nth-of-type(1):before { content: "   Name    "; }
    td:nth-of-type(2):before { content: "Email"; }
    td:nth-of-type(3):before { content: "Airport"; }
    td:nth-of-type(4):before { content: "Has Download"; }
    td:nth-of-type(5):before { content: "Action"; }
  
}
</style>
    <div class="page-content">


        <div class="page-header">
            <h1>
                Customers
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

                        <!--div class="row">

                                {{ Form::open(array('route' => 'customers.index', 'method' => 'get')) }}


                                {{ Form::select('airport_id',$airportsList,Input::get("airport_id")) }}


                                {{ Form::label('has_downloaded', 'Has Downloaded') }}

                                {{ Form::select('downloaded',["all"=>"All","Yes"=>"Yes","No"=>"No"],Input::get("downloaded")) }}

                                <input value="Search" type="submit" class="btn btn-sm btn-success"/>
                                  <a href="{{ route("subscribers.index") }}" class="btn btn-sm btn-primary">Reset</a>
                                {{ Form::close() }}



                        </div-->
                    </div>
                    <br>
                    <br>

                    <a id="excel" class="btn btn-primary btn-xs" style="float: right;" href='{{ route("export_customer_excel") }}'><i class="fa fa-file-excel-o"></i> Download Excel</a>
                  
                  
                <div class="table table-responsive">
                    <table id="simple-table" class="table  table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($subscribers as $sub)
                            <tr>
                                <td class="">{{ $sub->first_name }} {{ $sub->last_name }}</td>
                                
                                <td class="">{{ $sub->email }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
                {{ $subscribers->appends(request()->input())->links("vendor.pagination.default")

                   }}
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
