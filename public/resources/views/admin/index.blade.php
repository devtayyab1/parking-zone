@extends('admin.layout.master')

@section('content')


    <div class="page-content">


        <div class="page-header">
            <h1>
                Dashboard
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    overview &amp; stats 
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">


                <div class="row">
                    <div class="space-6"></div>

                    <div class="col-sm-7 infobox-container">
                        <div class="infobox infobox-green">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-plane"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo $sale_count; ?></span>
                                <div class="infobox-content">Airport parking</div>
                            </div>

                        </div>

                      
<a href="{{ route('roleCreate') }}">
                         <div class="infobox infobox-pink">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-users"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"></span>
                                <div class="infobox-content">Roles</div>
                            </div>

                        </div>
</a>
                        <!-- show count of today total start -->
                        <div class="infobox infobox-green">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-car"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{$todayTotal}}</span>
                                <div class="infobox-content">Total Orders</div>
                            </div>


                        </div>

                        <div class="infobox infobox-blue">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-car"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{$todayPpc}}</span>
                                <div class="infobox-content">PPC Orders</div>
                            </div>

                        </div> 

                        <div class="infobox infobox-green">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-car"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{$todayBing}}</span>
                                <div class="infobox-content">Bing Orders</div>
                            </div>

                        </div> 

                        <div class="infobox infobox-blue">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-car"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{$todayEmail}}</span>
                                <div class="infobox-content">Email Orders</div>
                            </div>

                        </div> 

                        <div class="infobox infobox-green">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-car"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{$todayOrg}}</span>
                                <div class="infobox-content">Organic Orders</div>
                            </div>

                        </div> 
                        <!-- show count of today total end -->



                        {{--<div class="space-6"></div>--}}



                       <!--  <div class="infobox infobox-green infobox-small infobox-dark">
                            <div class="infobox-progress">
                                <div class="easy-pie-chart percentage" data-percent="61" data-size="39">
                                    <span class="percent">0</span>
                                </div>
                            </div>

                            <div class="infobox-data">
                                <div class="infobox-content">Task</div>
                                <div class="infobox-content">Completion</div>
                            </div>
                        </div>
 -->
                        {{--<div class="infobox infobox-blue infobox-small infobox-dark">--}}
                            {{--<div class="infobox-chart">--}}
                                {{--<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>--}}
                            {{--</div>--}}

                            {{--<div class="infobox-data">--}}
                                {{--<div class="infobox-content">Earnings</div>--}}
                                {{--<div class="infobox-content">$32,000</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="infobox infobox-grey infobox-small infobox-dark">--}}
                            {{--<div class="infobox-icon">--}}
                                {{--<i class="ace-icon fa fa-download"></i>--}}
                            {{--</div>--}}

                            {{--<div class="infobox-data">--}}
                                {{--<div class="infobox-content">Downloads</div>--}}
                                {{--<div class="infobox-content">1,205</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        @if($role_nam == 'SuperAdmin'){
                        <div id="chart_div"></div>
                        @endif

                    </div>

                    <div class="vspace-12-sm"></div>

                    <div class="col-sm-5">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    Marketing Stats

                                </h5>

                                {{--<div class="widget-toolbar no-border">--}}
                                    {{--<div class="inline dropdown-hover">--}}
                                        {{--<button class="btn btn-minier btn-primary">--}}
                                            {{--This Week--}}
                                            {{--<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>--}}
                                        {{--</button>--}}

                                        {{--<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">--}}
                                            {{--<li class="active">--}}
                                                {{--<a href="#" class="blue">--}}
                                                    {{--<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>--}}
                                                    {{--This Week--}}
                                                {{--</a>--}}
                                            {{--</li>--}}

                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>--}}
                                                    {{--Last Week--}}
                                                {{--</a>--}}
                                            {{--</li>--}}

                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>--}}
                                                    {{--This Month--}}
                                                {{--</a>--}}
                                            {{--</li>--}}

                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>--}}
                                                    {{--Last Month--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>
                                   @if($role_nam=='Operations' || $role_nam=='Sales' || $role_nam=='SuperAdmin'|| $role_nam=='Developers'|| $role_nam=='Marketing')

                                    <div class="clearfix">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
															<span class="grey">
																Today's Sales Amount
															</span>
                                            <h4 class="bigger pull-right"> &pound; @if($today_amount["total"]>0) {{ $today_amount["total"] }} @else 0 @endif</h4>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
															<span class="grey">
																<i class="ace-icon fa fa-twitter-square fa-2x purple"></i>
																&nbsp; Monthly Sales Amount
															</span>
                                            <h4 class="bigger pull-right"> &pound; @if($monthly_amount["total"]>0) {{   $monthly_amount["total"]  }} @else 0 @endif</h4>
                                        </div>


                                    </div>
                                    @endif
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="hr hr32 hr-dotted"></div>

                <div class="row">
                    <div class="panel panel-primary" style="overflow: hidden;">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>
                                    Real Time Stats
                                    <br />
                                    <small style="color:white">current server uptime</small>
                                </h4>
                            </div>

                            <div class="panel-options">
                                <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                            </div>
                        </div>

                        <div class="panel-body no-padding">
                            <div id="rickshaw-chart-demo">
                                <div id="rickshaw-legend"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="hr hr32 hr-dotted"></div>
            </div>

                {{--<div class="row">--}}
                    {{--<div class="col-sm-5">--}}
                        {{--<div class="widget-box transparent">--}}
                            {{--<div class="widget-header widget-header-flat">--}}
                                {{--<h4 class="widget-title lighter">--}}
                                    {{--<i class="ace-icon fa fa-star orange"></i>--}}
                                    {{--Popular Domains--}}
                                {{--</h4>--}}

                                {{--<div class="widget-toolbar">--}}
                                    {{--<a href="#" data-action="collapse">--}}
                                        {{--<i class="ace-icon fa fa-chevron-up"></i>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="widget-body">--}}
                                {{--<div class="widget-main no-padding">--}}
                                    {{--<table class="table table-bordered table-striped">--}}
                                        {{--<thead class="thin-border-bottom">--}}
                                        {{--<tr>--}}
                                            {{--<th>--}}
                                                {{--<i class="ace-icon fa fa-caret-right blue"></i>name--}}
                                            {{--</th>--}}

                                            {{--<th>--}}
                                                {{--<i class="ace-icon fa fa-caret-right blue"></i>price--}}
                                            {{--</th>--}}

                                            {{--<th class="hidden-480">--}}
                                                {{--<i class="ace-icon fa fa-caret-right blue"></i>status--}}
                                            {{--</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}

                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                            {{--<td>internet.com</td>--}}

                                            {{--<td>--}}
                                                {{--<small>--}}
                                                    {{--<s class="red">$29.99</s>--}}
                                                {{--</small>--}}
                                                {{--<b class="green">$19.99</b>--}}
                                            {{--</td>--}}

                                            {{--<td class="hidden-480">--}}
                                                {{--<span class="label label-info arrowed-right arrowed-in">on sale</span>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr>--}}
                                            {{--<td>online.com</td>--}}

                                            {{--<td>--}}
                                                {{--<b class="blue">$16.45</b>--}}
                                            {{--</td>--}}

                                            {{--<td class="hidden-480">--}}
                                                {{--<span class="label label-success arrowed-in arrowed-in-right">approved</span>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr>--}}
                                            {{--<td>newnet.com</td>--}}

                                            {{--<td>--}}
                                                {{--<b class="blue">$15.00</b>--}}
                                            {{--</td>--}}

                                            {{--<td class="hidden-480">--}}
                                                {{--<span class="label label-danger arrowed">pending</span>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr>--}}
                                            {{--<td>web.com</td>--}}

                                            {{--<td>--}}
                                                {{--<small>--}}
                                                    {{--<s class="red">$24.99</s>--}}
                                                {{--</small>--}}
                                                {{--<b class="green">$19.95</b>--}}
                                            {{--</td>--}}

                                            {{--<td class="hidden-480">--}}
																	{{--<span class="label arrowed">--}}
																		{{--<s>out of stock</s>--}}
																	{{--</span>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr>--}}
                                            {{--<td>domain.com</td>--}}

                                            {{--<td>--}}
                                                {{--<b class="blue">$12.00</b>--}}
                                            {{--</td>--}}

                                            {{--<td class="hidden-480">--}}
                                                {{--<span class="label label-warning arrowed arrowed-right">SOLD</span>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div><!-- /.widget-main -->--}}
                            {{--</div><!-- /.widget-body -->--}}
                        {{--</div><!-- /.widget-box -->--}}
                    {{--</div><!-- /.col -->--}}

                    {{--<div class="col-sm-7">--}}
                        {{--<div class="widget-box transparent">--}}
                            {{--<div class="widget-header widget-header-flat">--}}
                                {{--<h4 class="widget-title lighter">--}}
                                    {{--<i class="ace-icon fa fa-signal"></i>--}}
                                    {{--Sale Stats--}}
                                {{--</h4>--}}

                                {{--<div class="widget-toolbar">--}}
                                    {{--<a href="#" data-action="collapse">--}}
                                        {{--<i class="ace-icon fa fa-chevron-up"></i>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="widget-body">--}}
                                {{--<div class="widget-main padding-4">--}}
                                    {{--<div id="sales-charts"></div>--}}
                                {{--</div><!-- /.widget-main -->--}}
                            {{--</div><!-- /.widget-body -->--}}
                        {{--</div><!-- /.widget-box -->--}}
                    {{--</div><!-- /.col -->--}}
                {{--</div><!-- /.row -->--}}

                {{--<div class="hr hr32 hr-dotted"></div>--}}

                {{--<div class="row">--}}
                    {{--<div class="col-sm-6">--}}
                        {{--<div class="widget-box transparent" id="recent-box">--}}
                            {{--<div class="widget-header">--}}
                                {{--<h4 class="widget-title lighter smaller">--}}
                                    {{--<i class="ace-icon fa fa-rss orange"></i>RECENT--}}
                                {{--</h4>--}}

                                {{--<div class="widget-toolbar no-border">--}}
                                    {{--<ul class="nav nav-tabs" id="recent-tab">--}}
                                        {{--<li class="active">--}}
                                            {{--<a data-toggle="tab" href="#task-tab">Tasks</a>--}}
                                        {{--</li>--}}

                                        {{--<li>--}}
                                            {{--<a data-toggle="tab" href="#member-tab">Members</a>--}}
                                        {{--</li>--}}

                                        {{--<li>--}}
                                            {{--<a data-toggle="tab" href="#comment-tab">Comments</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="widget-body">--}}
                                {{--<div class="widget-main padding-4">--}}
                                    {{--<div class="tab-content padding-8">--}}
                                        {{--<div id="task-tab" class="tab-pane active">--}}
                                            {{--<h4 class="smaller lighter green">--}}
                                                {{--<i class="ace-icon fa fa-list"></i>--}}
                                                {{--Sortable Lists--}}
                                            {{--</h4>--}}

                                            {{--<ul id="tasks" class="item-list">--}}
                                                {{--<li class="item-orange clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Answering customer questions</span>--}}
                                                    {{--</label>--}}

                                                    {{--<div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#ECCB71" data-percent="42">--}}
                                                        {{--<span class="percent">42</span>%--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-red clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Fixing bugs</span>--}}
                                                    {{--</label>--}}

                                                    {{--<div class="pull-right action-buttons">--}}
                                                        {{--<a href="#" class="blue">--}}
                                                            {{--<i class="ace-icon fa fa-pencil bigger-130"></i>--}}
                                                        {{--</a>--}}

                                                        {{--<span class="vbar"></span>--}}

                                                        {{--<a href="#" class="red">--}}
                                                            {{--<i class="ace-icon fa fa-trash-o bigger-130"></i>--}}
                                                        {{--</a>--}}

                                                        {{--<span class="vbar"></span>--}}

                                                        {{--<a href="#" class="green">--}}
                                                            {{--<i class="ace-icon fa fa-flag bigger-130"></i>--}}
                                                        {{--</a>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-default clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Adding new features</span>--}}
                                                    {{--</label>--}}

                                                    {{--<div class="pull-right pos-rel dropdown-hover">--}}
                                                        {{--<button class="btn btn-minier bigger btn-primary">--}}
                                                            {{--<i class="ace-icon fa fa-cog icon-only bigger-120"></i>--}}
                                                        {{--</button>--}}

                                                        {{--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-caret dropdown-close dropdown-menu-right">--}}
                                                            {{--<li>--}}
                                                                {{--<a href="#" class="tooltip-success" data-rel="tooltip" title="Mark&nbsp;as&nbsp;done">--}}
																					{{--<span class="green">--}}
																						{{--<i class="ace-icon fa fa-check bigger-110"></i>--}}
																					{{--</span>--}}
                                                                {{--</a>--}}
                                                            {{--</li>--}}

                                                            {{--<li>--}}
                                                                {{--<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">--}}
																					{{--<span class="red">--}}
																						{{--<i class="ace-icon fa fa-trash-o bigger-110"></i>--}}
																					{{--</span>--}}
                                                                {{--</a>--}}
                                                            {{--</li>--}}
                                                        {{--</ul>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-blue clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Upgrading scripts used in template</span>--}}
                                                    {{--</label>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-grey clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Adding new skins</span>--}}
                                                    {{--</label>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-green clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Updating server software up</span>--}}
                                                    {{--</label>--}}
                                                {{--</li>--}}

                                                {{--<li class="item-pink clearfix">--}}
                                                    {{--<label class="inline">--}}
                                                        {{--<input type="checkbox" class="ace" />--}}
                                                        {{--<span class="lbl"> Cleaning up</span>--}}
                                                    {{--</label>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}

                                        {{--<div id="member-tab" class="tab-pane">--}}
                                            {{--<div class="clearfix">--}}
                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Bob Doe's avatar" src="assets/images/avatars/user.jpg" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Bob Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">20 min</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-warning label-sm">pending</span>--}}

                                                            {{--<div class="inline position-relative">--}}
                                                                {{--<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">--}}
                                                                    {{--<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>--}}
                                                                {{--</button>--}}

                                                                {{--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">--}}
                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">--}}
																							{{--<span class="green">--}}
																								{{--<i class="ace-icon fa fa-check bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">--}}
																							{{--<span class="orange">--}}
																								{{--<i class="ace-icon fa fa-times bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">--}}
																							{{--<span class="red">--}}
																								{{--<i class="ace-icon fa fa-trash-o bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}
                                                                {{--</ul>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Joe Doe's avatar" src="assets/images/avatars/avatar2.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Joe Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">1 hour</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-warning label-sm">pending</span>--}}

                                                            {{--<div class="inline position-relative">--}}
                                                                {{--<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">--}}
                                                                    {{--<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>--}}
                                                                {{--</button>--}}

                                                                {{--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">--}}
                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">--}}
																							{{--<span class="green">--}}
																								{{--<i class="ace-icon fa fa-check bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">--}}
																							{{--<span class="orange">--}}
																								{{--<i class="ace-icon fa fa-times bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">--}}
																							{{--<span class="red">--}}
																								{{--<i class="ace-icon fa fa-trash-o bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}
                                                                {{--</ul>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Jim Doe's avatar" src="assets/images/avatars/avatar.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Jim Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">2 hour</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-warning label-sm">pending</span>--}}

                                                            {{--<div class="inline position-relative">--}}
                                                                {{--<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">--}}
                                                                    {{--<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>--}}
                                                                {{--</button>--}}

                                                                {{--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">--}}
                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">--}}
																							{{--<span class="green">--}}
																								{{--<i class="ace-icon fa fa-check bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">--}}
																							{{--<span class="orange">--}}
																								{{--<i class="ace-icon fa fa-times bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}

                                                                    {{--<li>--}}
                                                                        {{--<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">--}}
																							{{--<span class="red">--}}
																								{{--<i class="ace-icon fa fa-trash-o bigger-110"></i>--}}
																							{{--</span>--}}
                                                                        {{--</a>--}}
                                                                    {{--</li>--}}
                                                                {{--</ul>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Alex Doe's avatar" src="assets/images/avatars/avatar5.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Alex Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">3 hour</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-danger label-sm">blocked</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Bob Doe's avatar" src="assets/images/avatars/avatar2.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Bob Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">6 hour</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-success label-sm arrowed-in">approved</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Susan's avatar" src="assets/images/avatars/avatar3.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Susan</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">yesterday</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-success label-sm arrowed-in">approved</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Phil Doe's avatar" src="assets/images/avatars/avatar4.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Phil Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">2 days ago</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-info label-sm arrowed-in arrowed-in-right">online</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv memberdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Alexa Doe's avatar" src="assets/images/avatars/avatar1.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Alexa Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">3 days ago</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div>--}}
                                                            {{--<span class="label label-success label-sm arrowed-in">approved</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="space-4"></div>--}}

                                            {{--<div class="center">--}}
                                                {{--<i class="ace-icon fa fa-users fa-2x green middle"></i>--}}

                                                {{--&nbsp;--}}
                                                {{--<a href="#" class="btn btn-sm btn-white btn-info">--}}
                                                    {{--See all members &nbsp;--}}
                                                    {{--<i class="ace-icon fa fa-arrow-right"></i>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}

                                            {{--<div class="hr hr-double hr8"></div>--}}
                                        {{--</div><!-- /.#member-tab -->--}}

                                        {{--<div id="comment-tab" class="tab-pane">--}}
                                            {{--<div class="comments">--}}
                                                {{--<div class="itemdiv commentdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Bob Doe's Avatar" src="assets/images/avatars/avatar.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Bob Doe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="green">6 min</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="text">--}}
                                                            {{--<i class="ace-icon fa fa-quote-left"></i>--}}
                                                            {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="tools">--}}
                                                        {{--<div class="inline position-relative">--}}
                                                            {{--<button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown">--}}
                                                                {{--<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>--}}
                                                            {{--</button>--}}

                                                            {{--<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">--}}
                                                                {{--<li>--}}
                                                                    {{--<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">--}}
																						{{--<span class="green">--}}
																							{{--<i class="ace-icon fa fa-check bigger-110"></i>--}}
																						{{--</span>--}}
                                                                    {{--</a>--}}
                                                                {{--</li>--}}

                                                                {{--<li>--}}
                                                                    {{--<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">--}}
																						{{--<span class="orange">--}}
																							{{--<i class="ace-icon fa fa-times bigger-110"></i>--}}
																						{{--</span>--}}
                                                                    {{--</a>--}}
                                                                {{--</li>--}}

                                                                {{--<li>--}}
                                                                    {{--<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">--}}
																						{{--<span class="red">--}}
																							{{--<i class="ace-icon fa fa-trash-o bigger-110"></i>--}}
																						{{--</span>--}}
                                                                    {{--</a>--}}
                                                                {{--</li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv commentdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Jennifer's Avatar" src="assets/images/avatars/avatar1.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Jennifer</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="blue">15 min</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="text">--}}
                                                            {{--<i class="ace-icon fa fa-quote-left"></i>--}}
                                                            {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="tools">--}}
                                                        {{--<div class="action-buttons bigger-125">--}}
                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-pencil blue"></i>--}}
                                                            {{--</a>--}}

                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-trash-o red"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv commentdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Joe's Avatar" src="assets/images/avatars/avatar2.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Joe</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="orange">22 min</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="text">--}}
                                                            {{--<i class="ace-icon fa fa-quote-left"></i>--}}
                                                            {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="tools">--}}
                                                        {{--<div class="action-buttons bigger-125">--}}
                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-pencil blue"></i>--}}
                                                            {{--</a>--}}

                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-trash-o red"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                {{--<div class="itemdiv commentdiv">--}}
                                                    {{--<div class="user">--}}
                                                        {{--<img alt="Rita's Avatar" src="assets/images/avatars/avatar3.png" />--}}
                                                    {{--</div>--}}

                                                    {{--<div class="body">--}}
                                                        {{--<div class="name">--}}
                                                            {{--<a href="#">Rita</a>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="time">--}}
                                                            {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                            {{--<span class="red">50 min</span>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="text">--}}
                                                            {{--<i class="ace-icon fa fa-quote-left"></i>--}}
                                                            {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="tools">--}}
                                                        {{--<div class="action-buttons bigger-125">--}}
                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-pencil blue"></i>--}}
                                                            {{--</a>--}}

                                                            {{--<a href="#">--}}
                                                                {{--<i class="ace-icon fa fa-trash-o red"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="hr hr8"></div>--}}

                                            {{--<div class="center">--}}
                                                {{--<i class="ace-icon fa fa-comments-o fa-2x green middle"></i>--}}

                                                {{--&nbsp;--}}
                                                {{--<a href="#" class="btn btn-sm btn-white btn-info">--}}
                                                    {{--See all comments &nbsp;--}}
                                                    {{--<i class="ace-icon fa fa-arrow-right"></i>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}

                                            {{--<div class="hr hr-double hr8"></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div><!-- /.widget-main -->--}}
                            {{--</div><!-- /.widget-body -->--}}
                        {{--</div><!-- /.widget-box -->--}}
                    {{--</div><!-- /.col -->--}}

                    {{--<div class="col-sm-6">--}}
                        {{--<div class="widget-box">--}}
                            {{--<div class="widget-header">--}}
                                {{--<h4 class="widget-title lighter smaller">--}}
                                    {{--<i class="ace-icon fa fa-comment blue"></i>--}}
                                    {{--Conversation--}}
                                {{--</h4>--}}
                            {{--</div>--}}

                            {{--<div class="widget-body">--}}
                                {{--<div class="widget-main no-padding">--}}
                                    {{--<div class="dialogs">--}}
                                        {{--<div class="itemdiv dialogdiv">--}}
                                            {{--<div class="user">--}}
                                                {{--<img alt="Alexa's Avatar" src="assets/images/avatars/avatar1.png" />--}}
                                            {{--</div>--}}

                                            {{--<div class="body">--}}
                                                {{--<div class="time">--}}
                                                    {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                    {{--<span class="green">4 sec</span>--}}
                                                {{--</div>--}}

                                                {{--<div class="name">--}}
                                                    {{--<a href="#">Alexa</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>--}}

                                                {{--<div class="tools">--}}
                                                    {{--<a href="#" class="btn btn-minier btn-info">--}}
                                                        {{--<i class="icon-only ace-icon fa fa-share"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="itemdiv dialogdiv">--}}
                                            {{--<div class="user">--}}
                                                {{--<img alt="John's Avatar" src="assets/images/avatars/avatar.png" />--}}
                                            {{--</div>--}}

                                            {{--<div class="body">--}}
                                                {{--<div class="time">--}}
                                                    {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                    {{--<span class="blue">38 sec</span>--}}
                                                {{--</div>--}}

                                                {{--<div class="name">--}}
                                                    {{--<a href="#">John</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>--}}

                                                {{--<div class="tools">--}}
                                                    {{--<a href="#" class="btn btn-minier btn-info">--}}
                                                        {{--<i class="icon-only ace-icon fa fa-share"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="itemdiv dialogdiv">--}}
                                            {{--<div class="user">--}}
                                                {{--<img alt="Bob's Avatar" src="assets/images/avatars/user.jpg" />--}}
                                            {{--</div>--}}

                                            {{--<div class="body">--}}
                                                {{--<div class="time">--}}
                                                    {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                    {{--<span class="orange">2 min</span>--}}
                                                {{--</div>--}}

                                                {{--<div class="name">--}}
                                                    {{--<a href="#">Bob</a>--}}
                                                    {{--<span class="label label-info arrowed arrowed-in-right">admin</span>--}}
                                                {{--</div>--}}
                                                {{--<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>--}}

                                                {{--<div class="tools">--}}
                                                    {{--<a href="#" class="btn btn-minier btn-info">--}}
                                                        {{--<i class="icon-only ace-icon fa fa-share"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="itemdiv dialogdiv">--}}
                                            {{--<div class="user">--}}
                                                {{--<img alt="Jim's Avatar" src="assets/images/avatars/avatar4.png" />--}}
                                            {{--</div>--}}

                                            {{--<div class="body">--}}
                                                {{--<div class="time">--}}
                                                    {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                    {{--<span class="grey">3 min</span>--}}
                                                {{--</div>--}}

                                                {{--<div class="name">--}}
                                                    {{--<a href="#">Jim</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>--}}

                                                {{--<div class="tools">--}}
                                                    {{--<a href="#" class="btn btn-minier btn-info">--}}
                                                        {{--<i class="icon-only ace-icon fa fa-share"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="itemdiv dialogdiv">--}}
                                            {{--<div class="user">--}}
                                                {{--<img alt="Alexa's Avatar" src="assets/images/avatars/avatar1.png" />--}}
                                            {{--</div>--}}

                                            {{--<div class="body">--}}
                                                {{--<div class="time">--}}
                                                    {{--<i class="ace-icon fa fa-clock-o"></i>--}}
                                                    {{--<span class="green">4 min</span>--}}
                                                {{--</div>--}}

                                                {{--<div class="name">--}}
                                                    {{--<a href="#">Alexa</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>--}}

                                                {{--<div class="tools">--}}
                                                    {{--<a href="#" class="btn btn-minier btn-info">--}}
                                                        {{--<i class="icon-only ace-icon fa fa-share"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<form>--}}
                                        {{--<div class="form-actions">--}}
                                            {{--<div class="input-group">--}}
                                                {{--<input placeholder="Type your message here ..." type="text" class="form-control" name="message" />--}}
                                                {{--<span class="input-group-btn">--}}
																	{{--<button class="btn btn-sm btn-info no-radius" type="button">--}}
																		{{--<i class="ace-icon fa fa-share"></i>--}}
																		{{--Send--}}
																	{{--</button>--}}
																{{--</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div><!-- /.widget-main -->--}}
                            {{--</div><!-- /.widget-body -->--}}
                        {{--</div><!-- /.widget-box -->--}}
                    {{--</div><!-- /.col -->--}}
                {{--</div><!-- /.row -->--}}

                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
@endsection
@section("footer-script")
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/rickshaw/rickshaw.min.css') }}">

    <script src="{{ asset('assets/rickshaw/vendor/d3.v3.js') }}"></script>
    <script src="{{ asset('assets/rickshaw/rickshaw.min.js') }}"></script>
    <script type="text/javascript">

        //

        jQuery(function ($) {
            //request();

// monthly chart start
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('timeofday', 'Monthly Sales');
                data.addColumn('number', 'Monthly Sales');
                var d = [1,2,3,5,6,7,2,3,3,4,3,5,7,2,4,3,5,4,5,6,3,2,9];

                var dd=[];
                for(var i=0; i<d.length; i++)
                {
                    dd.push([{v: [i, 0, 0], f:"'"+d[i]+"'"}, d[i]]);
                }

                data.addRows(dd);


                var ticks_d=[];
                for(var i=0; i<=30; i++)
                {
                    var i2 = i+1;
                    ticks_d.push({v: i, f:i2});
                }




                var options = {
                    title: 'Monthly Sales',

//                    hAxis: {
//                        title: 'Monthly Sales',
//                        format: 'short',
//                        viewWindow: {
//                            min: [1, 30, 0],
//                            max: [31, 30, 0]
//                        }
//                    }
                    hAxis: {
                        title: 'Monthly Sales',

                        baseline: 0,
                        gridlines: {
                            count: 31
                        },
                        ticks: ticks_d, // <------- This does the trick
                    },
                };

                var chart = new google.visualization.ColumnChart(
                    document.getElementById('chart_div'));

                chart.draw(data, options);
            }
// monthly chart end

            $('.easy-pie-chart.percentage').each(function () {
                var $box = $(this).closest('.infobox');
                var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                var size = parseInt($(this).data('size')) || 50;
                $(this).easyPieChart({
                    barColor: barColor,
                    trackColor: trackColor,
                    scaleColor: false,
                    lineCap: 'butt',
                    lineWidth: parseInt(size / 10),
                    animate: ace.vars['old_ie'] ? false : 1000,
                    size: size
                });
            })

            $('.sparkline').each(function () {
                var $box = $(this).closest('.infobox');
                var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                $(this).sparkline('html',
                    {
                        tagValuesAttribute: 'data-values',
                        type: 'bar',
                        barColor: barColor,
                        chartRangeMin: $(this).data('min') || 0
                    });
            });


            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers
            $.resize.throttleWindow = false;

            var placeholder = $('#piechart-placeholder').css({'width': '90%', 'min-height': '150px'});
            var data = [
            @if($role_nam=="Marketing")
                {label: "Google", data: @if($count_paid_bookings>0){{  $count_google_booking_source }}@else 0 @endif, color: "#68BC31"},
                {label: "Bing", data: @if($count_paid_bookings>0){{ $count_bing_booking_source }}@else 0 @endif, color: "#68BC31"},
            @endif

            @if($role_nam=="Operations" || $role_nam=='Sales' )
                {label: "Google", data: @if($count_paid_bookings>0){{  $count_google_booking_source }}@else 0 @endif, color: "#68BC31"},
                {label: "Bing", data: @if($count_paid_bookings>0){{ $count_bing_booking_source }}@else 0 @endif, color: "#68BC31"},
            @endif

             @if($role_nam=="SuperAdmin")
                {label: "Paid", data: @if($count_paid_bookings>0) {{ $count_paid_bookings }} @else 0 @endif, color: "#68BC31"},
                {label: "Organic", data: @if($count_organic_booking_source>0){{ $count_organic_booking_source }} @else 0 @endif, color: "#68BC31"},
                {label: "Mail Sales", data: @if($count_email_booking_source>0) {{ $count_email_booking_source }} @else 0 @endif, color: "#68BC31"},
              @endif



            ]

            function drawPieChart(placeholder, data, position) {
                $.plot(placeholder, data, {
                    series: {
                        pie: {
                            show: true,
                            tilt: 0.8,
                            highlight: {
                                opacity: 0.25
                            },
                            stroke: {
                                color: '#fff',
                                width: 2
                            },
                            startAngle: 2
                        }
                    },
                    legend: {
                        show: true,
                        position: position || "ne",
                        labelBoxBorderColor: null,
                        margin: [-30, 15]
                    }
                    ,
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                })
            }

            drawPieChart(placeholder, data);

            /**
             we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
             so that's not needed actually.
             */
            placeholder.data('chart', data);
            placeholder.data('draw', drawPieChart);


            //pie chart tooltip example
            var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
            var previousPoint = null;

            placeholder.on('plothover', function (event, pos, item) {

                if (item) {
                    if (previousPoint != item.seriesIndex) {
                        console.log(item);
                        previousPoint = item.seriesIndex;
                        var tip = item.series['label'] + " : £" + item.series['data'][0][1]+" Booking ";
                        $tooltip.show().children(0).text(tip);
                    }
                    $tooltip.css({top: pos.pageY + 10, left: pos.pageX + 10});
                } else {
                    $tooltip.hide();
                    previousPoint = null;
                }

            });

            /////////////////////////////////////
            $(document).one('ajaxloadstart.page', function (e) {
                $tooltip.remove();
            });


            var d1 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
                d1.push([i, Math.sin(i)]);
            }

            var d2 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
                d2.push([i, Math.cos(i)]);
            }

            var d3 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.2) {
                d3.push([i, Math.tan(i)]);
            }


            var sales_charts = $('#sales-charts').css({'width': '100%', 'height': '220px'});
            $.plot("#sales-charts", [
                {label: "Domains", data: d1},
                {label: "Hosting", data: d2},
                {label: "Services", data: d3}
            ], {
                hoverable: true,
                shadowSize: 0,
                series: {
                    lines: {show: true},
                    points: {show: true}
                },
                xaxis: {
                    tickLength: 0
                },
                yaxis: {
                    ticks: 10,
                    min: -2,
                    max: 2,
                    tickDecimals: 3
                },
                grid: {
                    backgroundColor: {colors: ["#fff", "#fff"]},
                    borderWidth: 1,
                    borderColor: '#555'
                }
            });


            $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});

            function tooltip_placement(context, source) {
                var $source = $(source);
                var $parent = $source.closest('.tab-content')
                var off1 = $parent.offset();
                var w1 = $parent.width();

                var off2 = $source.offset();
                //var w2 = $source.width();

                if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
                return 'left';
            }


            $('.dialogs,.comments').ace_scroll({
                size: 300
            });


            //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
            //so disable dragging when clicking on label
            var agent = navigator.userAgent.toLowerCase();
            if (ace.vars['touch'] && ace.vars['android']) {
                $('#tasks').on('touchstart', function (e) {
                    var li = $(e.target).closest('#tasks li');
                    if (li.length == 0) return;
                    var label = li.find('label.inline').get(0);
                    if (label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation();
                });
            }

            $('#tasks').sortable({
                    opacity: 0.8,
                    revert: true,
                    forceHelperSize: true,
                    placeholder: 'draggable-placeholder',
                    forcePlaceholderSize: true,
                    tolerance: 'pointer',
                    stop: function (event, ui) {
                        //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                        $(ui.item).css('z-index', 'auto');
                    }
                }
            );
            $('#tasks').disableSelection();
            $('#tasks input:checkbox').removeAttr('checked').on('click', function () {
                if (this.checked) $(this).closest('li').addClass('selected');
                else $(this).closest('li').removeClass('selected');
            });


            //show the dropdowns on top or bottom depending on window height and menu position
            $('#task-tab .dropdown-hover').on('mouseenter', function (e) {
                var offset = $(this).offset();

                var $w = $(window)
                if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
                    $(this).addClass('dropup');
                else $(this).removeClass('dropup');
            });






        });
        function getRandomInt(min, max)
        {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        //rakshaw chart
        var seriesData = [ [], [] ];
        var random = new Rickshaw.Fixtures.RandomData(50);
        for (var i = 0; i < 50; i++)
        {
            random.addData(seriesData);
        }

        var graph = new Rickshaw.Graph( {
            element: document.getElementById("rickshaw-chart-demo"),
            height: 193,
            renderer: 'area',
            stroke: false,
            preserve: true,
            series: [{
                color: '#73c8ff',
                data: seriesData[0],
                name: 'Upload'
            }, {
                color: '#e0f2ff',
                data: seriesData[1],
                name: 'Download'
            }
            ]
        } );

        graph.render();

        var hoverDetail = new Rickshaw.Graph.HoverDetail( {
            graph: graph,
            xFormatter: function(x) {
                return new Date(x * 1000).toString();
            }
        } );

        var legend = new Rickshaw.Graph.Legend( {
            graph: graph,
            element: document.getElementById('rickshaw-legend')
        } );

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight( {
            graph: graph,
            legend: legend
        } );

        setInterval( function() {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        }, 500 );
    </script>
@endsection