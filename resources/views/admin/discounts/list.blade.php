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

    td:nth-of-type(1):before { content: "   Type    "; }

    td:nth-of-type(2):before { content: "Discount for"; }

    td:nth-of-type(3):before { content: "Promo"; }

    td:nth-of-type(4):before { content: "Start Date"; }

    td:nth-of-type(5):before { content: "End Date"; }

    td:nth-of-type(6):before { content: "Discount Value"; }

    td:nth-of-type(7):before { content: "Used at Quote"; }

    td:nth-of-type(8):before { content: "Used when Confirm"; }

    td:nth-of-type(9):before { content: "Status"; }

    td:nth-of-type(10):before { content: "Action"; }

}

</style>





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

                         <div class="row">

                <div class="col-md-12">

                            <form action="{{ route('discounts.index') }}" method="get" class="form-inline" style="margin-bottom: 10px;">

                    

                 <div class="form-group">

                       



                        <div class="col-sm-12">
                            Booking Type
                            <select name="parking_type" id="parking_type" class="form-control" aria-invalid="false">

                                <option @if(Input::get('parking_type')=="airport_parking") {{ "selected='selected'"}} @endif  value="airport_parking">Airport Parking</option>

                                <option @if(Input::get('parking_type')=="airport_hotel") {{ "selected='selected'"}} @endif  value="airport_hotel">Airport Hotel</option>

                                <option @if(Input::get('parking_type')=="airport_hotel_parking") {{ "selected='selected'"}} @endif  value="airport_hotel_parking">Airport Hotel Parking</option>

                                <option @if(Input::get('parking_type')=="airport_lounges") {{ "selected='selected'"}} @endif value="airport_lounges">Airport Lounges</option>

                            </select>

                        </div>

                    </div>

                     

                    



                     <div class="form-group" >

                        

                        <div class="col-sm-12">
                        Discount For
                            <select id="discount_for" name="discount_for" class="form-control" aria-invalid="false">

                             

                                <option @if(Input::get('discount_for')=="PPC") {{ "selected='selected'"}} @endif value="PPC" >PPC</option>

                                <option @if(Input::get('discount_for')=="BING") {{ "selected='selected'"}} @endif value="BING" >BING</option>

                                <option @if(Input::get('discount_for')=="EM") {{ "selected='selected'"}} @endif value="EM" >E Marketing</option>

                                <option @if(Input::get('discount_for')=="AF") {{ "selected='selected'"}} @endif value="AF" >Affiliate Feature</option>

                                <option @if(Input::get('discount_for')=="Og") {{ "selected='selected'"}} @endif value="Og" >Organic</option>

                                <option @if(Input::get('discount_for')=="FB") {{ "selected='selected'"}} @endif value="FB" >FaceBook</option>

                                <option @if(Input::get('discount_for')=="Ln") {{ "selected='selected'"}} @endif value="Ln" >LinkedIn</option>

                                <option @if(Input::get('discount_for')=="In") {{ "selected='selected'"}} @endif value="In" >Instagram</option>

                                <option @if(Input::get('discount_for')=="G+") {{ "selected='selected'"}} @endif value="G+" >Google+</option>

                                <option @if(Input::get('discount_for')=="Pi") {{ "selected='selected'"}} @endif value="Pi" >Pinterest</option>

                                <option @if(Input::get('discount_for')=="Tw") {{ "selected='selected'"}} @endif value="Tw" >Twiter</option>

                                <option @if(Input::get('discount_for')=="Yt") {{ "selected='selected'"}} @endif value="Yt" >Youtube</option>

                                <option @if(Input::get('discount_for')=="Blg") {{ "selected='selected'"}} @endif value="Blg" >Bloging</option>

                                <option @if(Input::get('discount_for')=="BK") {{ "selected='selected'"}} @endif value="BK" >Backend</option>

                            </select>

                        </div>

                    </div>



                  

   <div class="form-group">

                    


                        <div class="col-sm-12">
                        Is Active
                            <select name="status" class="form-control" aria-invalid="false">

                                <option @if(Input::get('status')=="yes") {{ "selected='selected'"}} @endif   value="yes">Yes</option>

                                <option @if(Input::get('status')=="no") {{ "selected='selected'"}} @endif  value="no">No</option>

                            </select>

                        </div>

                    </div>

                        





                        <div class="form-group" style="margin-top:2%">

                             <input value="Search" type="submit" class="btn  btn-success"/>

                            <a href="{{ route("discounts.index") }}" class="btn btn-primary">Reset</a>

                        </div>

                    </form>

               

                        <a style="margin-bottom: 9px;" class="btn btn-success"

                           href="{{ route("discounts.create") }}"> Add New</a>





<div class="table-responsive">





                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">

                            <thead>

                            <tr>



                                <th>Type</th>

                                <th>Discount for</th>

                                <th>Promo</th>

                                <th>Start Date</th>

                                <th>End Date</th>

                                <th>Discount Value</th>
                                
                                <th>Agent</th>

                                <th>Used at Quote</th>

                                <th>Used when Confirm</th>

                                <th>Status</th>

                                <th></th>





                            </tr>

                            </thead>



                            <tbody>

                            @foreach($discounts as $discount)

                                <tr>





                                    <td class="">{{ $discount->discount_type }}</td>

                                    <td class="">{{ $discount->discount_for }}</td>

                                    <td class="">{{ $discount->promo }}</td>

                                    <td class="">{{ $discount->start_date }}</td>

                                    <td class="">{{ $discount->end_date }}</td>

                                    <td class="">
                                        {{ $discount->discount_value }}
                                        @if($discount->discount_type == 'percent')
                                            %
                                        @else
                                            GBP   
                                        @endif
                                    </td>
                                    <td>
                                        @if($discount->agent_id == '1')
                                        {{ "ParkingZone" }}
                                        @elseif($discount->agent_id == '2')
                                        {{ "YayParking" }}
                                        @elseif($discount->agent_id == '3')
                                        {{ "Zairport" }}
                                        @elseif($discount->agent_id == '4')
                                        {{ "Eztrip" }}
                                        @elseif($discount->agent_id == '5')
                                        {{ "Travelez" }}
                                           @endif
                                        
                                    </td>

                                    <td class=""></td>

                                    <td class=""></td>

                                    <td class="">{{ $discount->status }}</td>





                                    <td>

                                        <div class="btn-group">



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

                    </div>



                       



                    </div><!-- /.span -->

                </div><!-- /.row -->





                <!-- PAGE CONTENT ENDS -->

            </div><!-- /.col -->

        </div><!-- /.row -->

    </div>

    @endsection

@section("footer-script")

    <script src="{{ secure_asset("assets/js/jquery.dataTables.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/jquery.dataTables.bootstrap.min.js") }}"></script>

    <script src="{{ secure_asset("assets/js/dataTables.buttons.min.js") }}"></script>





    <!-- inline scripts related to this page -->

        <script type="text/javascript">

            jQuery(function($) {

                //initiate dataTables plugin

                var myTable = 

                $('#dynamic-table')

                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)

                .DataTable( {

                    bAutoWidth: false,

                    // "aoColumns": [

                    //   { "bSortable": false },

                    //   null, null,null, null, null,

                    //   { "bSortable": false }

                    // ],

                    // "aaSorting": [],

                    

                    

                    //"bProcessing": true,

                    //"bServerSide": true,

                    //"sAjaxSource": "http://127.0.0.1/table.php"   ,

            

                    //,

                    //"sScrollY": "200px",

                    //"bPaginate": false,

            

                    //"sScrollX": "100%",

                    //"sScrollXInner": "120%",

                    //"bScrollCollapse": true,

                    //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"

                    //you may want to wrap the table inside a "div.dataTables_borderWrap" element

            

                    //"iDisplayLength": 50

            

            

                    select: {

                        style: 'multi'

                    }

                } );

            

                

                

         

                

                

                

                

                

               

            

            

            

            

                /////////////////////////////////

                //table checkboxes

                $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

                

                

            

            

            

                $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {

                    e.stopImmediatePropagation();

                    e.stopPropagation();

                    e.preventDefault();

                });

                

                

              

            

            })

        </script>

@endsection