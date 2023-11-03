<head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <meta charset="utf-8" />

        <title> Dashboard</title>



        <meta name="description" content="overview &amp; stats" />

     

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <meta name="title" content="Airport Parking, Airport Hotels and Airport Lounges">

        <meta name="keywords" content="airport parking, airport car parking, parking airport, cheap airport parking, airport, parking, car, park">

        <meta content="The UK most popular choice for Airport Parking, parkingzone give you the best deals at Gatwick, Heathrow, Stansted, Manchester and all major UK airports."  name="description">

        <meta name="author" content="">

        <!-- bootstrap & fontawesome -->

        <link rel="stylesheet" href=" {{ secure_asset('assets/css/admin.bootstrap.min.css') }}" type="text/css" />

        <link rel="stylesheet" href="{{ secure_asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />
          <link rel="icon" type="image/png" defer href="{{ secure_asset("assets/images/favicon-32x32.png") }}" sizes="32x32"/>
    <link rel="icon" type="image/png" defer href="{{ secure_asset("assets/images/favicon-16x16.png") }}" sizes="16x16"/>






@section('stylesheets')



        <!-- page specific plugin styles -->



        <!-- text fonts -->

        <link rel="stylesheet" href="{{ secure_asset('assets/css/fonts.googleapis.com.css') }}" />



        <!-- ace styles -->

        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />



        <!--[if lte IE 9]>

        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />

        <![endif]-->

        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-skins.min.css') }}" />

        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-rtl.min.css') }}" />



        <!--[if lte IE 9]>

        <link rel="stylesheet" href="{{ secure_asset('assets/css/ace-ie.min.css') }}" />

        <![endif]-->

@show



        <!-- inline styles related to this page -->



        <!-- ace settings handler -->

        <script src="{{ secure_asset('assets/js/ace-extra.min.js') }}"></script>



        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->



        <!--[if lte IE 8]>

        <script src="{{ secure_asset('assets/js/html5shiv.min.js') }}"></script>

        <script src="{{ secure_asset('assets/js/respond.min.js') }}"></script>



        <![endif]-->

        <!--[if !IE]> -->

        <script src="{{ secure_asset("assets/js/jquery-2.1.4.min.js") }}"></script>

		<style>
        .nav-list > li.administrators_link {display:none;}
        </style>

        <!-- <![endif]-->



        <!--[if IE]-->

        <script src="{{ secure_asset("assets/js/jquery-1.11.3.min.js") }}"></script>

        <!--[endif]-->
        @php $role =(auth::user()->with('roles', 'roles.role')->where('id',auth::id())->first()); 
                           
                            if($role->roles->role->name=='Marketing')
                            {
                            echo "<style>
	.manage_discount, .reports, .dashboard_link , .administrators_link , .ticketing_link, .green.dropdown-modal, a#excel {display:none !important;}
</style>";
                            }
                            
                            if($role->roles->role->name=='SuperAdmin')
                            {
                            echo "<style>
	.administrators_link {display:block !important;}
</style>";
                            }
                            
                            @endphp

        <style type="text/css">


.btn-group-sm>.btn, .btn-sm {
    padding: 2px 9px;
}
.table>thead>tr>th:last-child {
    border-right: 1px solid #ddd;
}
.table>thead>tr {
    color: #393939;
}
input[type=email], input[type=url], input[type=search], input[type=tel], input[type=color], input[type=text], input[type=password], input[type=datetime], input[type=datetime-local], input[type=date], input[type=month], input[type=time], input[type=week], input[type=number], textarea
{
	font-size: 13px;
}
.form-group {
    margin-top: 5px;
}

        </style>



    </head>

<div class="loading" id="loader_ajax" style="display: none;">Loading&#8230;</div>