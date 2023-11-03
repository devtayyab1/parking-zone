@extends('layouts.main')



@section('content')

    <style type="text/css">

        .col-md-12.padding0 {

            padding: 0px;

        }



        hr {

            border-top: 2px solid #fbc112 !important;

            margin-top: 0px !important;

            margin-bottom: 10px;

        }



        .head-text-bookingdetail {

            font-size: 14px;

            padding-right: 0px;



        }



        .my-class {

            width: 70% !important;

            margin-right: 27px;



        }



        .error {

            color: red;

        }



        .margin15 {

            margin-top: 10px;

        }



        #room-listing-blocks #room-list > li:hover {

            transform: none;

            box-shadow: none;

        }



        .btn.btn-prm {

            color: #fff;

            background-color: #428bca;

        }



        .btn-prm.btn-icon i {

            padding: 3px 6px;

            font-size: 17px;

        }



        .btn-prm.btn-icon.icon-left i {

            float: left;

            right: auto;

            left: 0;

        }



        .btn-prm.btn-icon.icon-left {

            padding-right: 12px;

            padding-left: 3px;

        }



        .fpp-ticket {

            margin-top: 0px;

            padding: 0;

            /*border: 1px solid #64cae6;*/

            /*background-color: #fff;*/

            border-radius: 3px;

        }



        .nrm-cont p {

            line-height: 21px;

            padding-bottom: 0px;



        }



        .maintab {

            padding-bottom: 12px;

            font-size: 22px;

        }



        .discount-fpp {

            margin: 0px;

            font-size: 27px;

            height: 67px;

            padding: 16px;

        }







        label {



            font-weight: 100 !important;

        }



        .margin-row {

            /*margin-top: 10px;*/

            /*border: 1px solid #65cae6;*/

            /*padding: 20px;*/

            border-radius: 3px;

        }



        .fpp-ticket .user .name {

            display: block;

            font-size: 0.9em;

            color: #fff;

        }



        .fpp-ticket.staff .user {

            background-color: #bbe5ec;

        }



        .fpp-ticket .user {

            padding: 5px 0;

            background-color: #63cae6;

            color: #fff;

        }



        .fpp-ticket .date {

            float: right;

            padding: 8px 10px;

            font-size: 0.8em;

        }



        .fpp-ticket .user i {

            float: left;

            font-size: 2.2em;

            padding: 2px 15px;

        }



        .fpp-ticket .user .type {

            display: block;

            font-weight: bold;

            font-size: 0.8em;

        }



        .list-group {

            margin-bottom: 0px;

        }

        #room-list {
            color: #444;
            border: 2px solid #340a4d;
            border-radius: 10px;
            margin-left: 15px;
        }
        .side-bar{
            padding: 30px;
            border: 2px solid #f09903;
            border-radius: 10px;
            color: #000;
        }
        .fa {
            font-size: 21px;
            margin-right: 6px;
            color: #340a4d;
            padding-bottom: 10px;
        }
        .fpp-ticket .user {
            padding: 5px 0;
            background-color: #f19a03;
            color: #fff;
        }
        .message p{
            padding-top: 10px;
        }
        .submit-btn{
            background-color: #53366d;
            color: #ffff;
            width: 50%;
            margin-top: 3%;
        }
        .ticket{
            color: #000;
            background-color: #f59d03;
            padding: 10px !important;
        }
        @media only screen and (max-width: 500px){
            #room-list {
                color: #444;
                border: 2px solid #340a4d;
                border-radius: 10px;
                 margin-left: 0px; 
                margin-top: 15px;
            }
        }
        @media only screen and (max-width: 500px){
            .side-bar{
                    padding: 40px;
            }
        }

    </style>

    <div class="home-container home-background">



     

        @include("frontend.header")





    </div><!-- end home-container -->

    <section id="room-listings" style="margin-top: 110px;" class="innerpage-wrapper">



        <div id="room-listing-blocks" class="innerpage-section-padding">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 side-bar">



                        <div class="row">



                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 " style="padding: 0px">

                                <h3 style="padding:13px 20px 0px !important" class="btn btn-lg btn-yellow col-md-12"><p class="ticket"><span><i

                                                    style="font-size: 26px;margin-right: 15px;"

                                                    class="fa fa-info"></i></span> Ticket Information</p></h3>





                                <div class="side-bar-block support-block"  style="margin-top:51px;    margin-bottom: 0px;">





                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Ref#</div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $ticket->ticket_id }}</p>

                                        </div>



                                    </div>

                                    <hr/>



                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Ticket Status

                                        </div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $ticket->status }}</p>

                                        </div>



                                    </div>

                                    <hr/>



                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Department</div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $department->name }}</p>

                                        </div>



                                    </div>

                                    <hr/>

                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Created#</div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $ticket->date }}</p>

                                        </div>



                                    </div>

                                    <hr/>





                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Priority</div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $ticket->urgency }}</p>

                                        </div>



                                    </div>



                                    <hr/>

                                    <div class="row">

                                        <div class="col-xs-6 col-md-4" class="head-text-bookingdetail">Progress</div>

                                        <div class="col-xs-6 col-md-8" style="padding-left:0px;">

                                            <p class="text-right"

                                               style="font-size: 14px;">{{ $companyMsg }}</p>

                                        </div>



                                    </div>





                                </div><!-- end columns -->





                                <h3 style="margin-top:10px;padding:13px 20px 0px !important"

                                    class="btn btn-lg btn-yellow col-md-12"><p class="ticket"><span><i

                                                    style="font-size: 26px;margin-right: 15px;"

                                                    class="fa fa-support"></i></span> Support</p></h3>





                                <div class="side-bar-block support-block"

                                     style="margin-top:35px;    margin-bottom: 0px;">





                                    <div class="row">

                                        <div class="col-md-12">

                                            <a href="" style="font-size: 14px;"> <i class="fa fa-ticket"> My Support

                                                    Tickets</i></a>

                                        </div>

                                        <hr/>

                                        <div class="col-md-12">

                                            <a href="{{ route("support") }}" style="font-size: 14px;"> <i class="fa fa-comments"> Open

                                                    Ticket </i></a>

                                        </div>



                                    </div>





                                </div><!-- end columns -->





                            </div><!-- end row -->



                        </div><!-- end columns -->



                    </div><!-- end row -->



                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">



                        <ul id="room-list" class="list-unstyled">

                            <li id="room-list-1">

                                <div class="room-list-block">

                                    <div class="row">

                                        <div class="col-xs-12  col-sm-12  col-md-12  col-lg-12 room-text"

                                             style="padding: 36px !important;">

                                            <div class="">





                                                    {{ Form::open(array('method'=>'post','route' => 'submit-reply', 'files' => true)) }}



                                                    @csrf

                                                    <input type="hidden" name="ticket_id"

                                                           value="{{  $ticket->id }}">

                                                    <input type="hidden" name="replyingadmin"

                                                           value="{{  $ticket->user_id }}">

                                                    <input type="hidden" name="ticket_ref"

                                                           value=" {{  $ticket->ticket_id }}">





                                                    <input type="hidden" name="reply_by"

                                                           value="Client">



                                                <h3 class="room-name">Reply {{ $ticket->title }} </h3>



                                                <div class="row margin15" id="vechile-detail">

                                                    <div class="col-lg-6 margin-vehicle">

                                                        <label class="normal-font">Name</label>

                                                        <span class="required-field">*</span>

                                                        <input class="form-control bf-inptfld" type="text"

                                                               name="name" id="name" disabled

                                                               placeholder="Name" value=" {{  $ticket->name }}">

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <label class="normal-font">Email</label>

                                                        <span class="required-field">*</span>

                                                        <input class="form-control bf-inptfld" type="text" name="email"

                                                               id="email" disabled placeholder="email" value=" {{  $ticket->email }}">

                                                        @if ($errors->has('email'))



                                                            <div class="alert alert-danger alert alert-danger col-xs-10 col-sm-5" style="clear: both;">

                                                                <strong>{{ $errors->first('email') }}</strong>

                                                            </div>

                                                        @endif

                                                    </div>



                                                </div>



                                                <div class="row margin15">

                                                    <div class="col-lg-12">

                                                        <label class="normal-font">Message</label>

                                                        <textarea name="message" required style="height: 100px"

                                                                  class="col-md-12 form-control"> </textarea>

                                                        @if ($errors->has('message'))



                                                            <div class="alert alert-danger alert alert-danger col-xs-12 col-sm-12" style="clear: both;">

                                                                <strong>{{ $errors->first('message') }}</strong>

                                                            </div>

                                                        @endif

                                                    </div>





                                                </div>





                                                <div class="row margin15">

                                                    <div class="col-lg-12">

                                                        <label class="normal-font">Attachments</label>

                                                        <input type="file" name="attatchment" class="form-control">

                                                    </div>





                                                </div>

                                                <div class="col-md-12 col-lg-12 margin15 text-center">

                                                    <input class="btn btn-yellow submit-btn" type="submit" name="reply_ticket"

                                                           value="Submit">

                                                </div>

                                                </form>



                                            </div><!-- end room-info -->

                                        </div><!-- end columns -->

                                    </div><!-- end row -->

                                </div><!-- end room-list-block -->

@php

    //$chat = $db->select("select * from " . $db->prefix . "tickets_chat where ticket_id = '" . $ticket['id'] . "' AND reply_to != 'Company' ORDER BY id desc");

                             use App\User;

                             use Illuminate\Support\Facades\DB;



                             $chat = \App\ticket_chat::where("ticket_id",$ticket->id)->orderBy("id","desc")->get();

                             //dd($chat);



                             foreach ($chat as $msg) {





                                //\App\ticket_chat::update();

                                  //   $db->update("UPDATE " . $db->prefix . "tickets_chat SET clientunread ='No' WHERE id='" . $msg['id'] . "'");

                                     if ($msg->reply_by == "Client") {

                                         $reply_by = $ticket->name;

                                         $reply_desg = "Client";

                                         $class = "";

                                         $bg = 'style="background-color: #ffba00;"';

                                     } elseif ($msg->reply_by == "Company") {

                                        // $admin = $db->get_row("select first_name,last_name from " . $db->prefix . "admin where id = '" . $ticket['company_admin_id'] . "'");

                                        // $reply_by = $admin['first_name'] . " " . $admin['last_name'];



                                         $user = DB::table("users")->where("id",$msg->company_admin_id)->first();



                                         $reply_by = $user->name;



                                         $reply_desg = "Company";

                                         $class = "companies";

                                         $bg = 'style="background-color: #fa6541;"';

                                     } else {

                                        // $admin = $db->get_row("select first_name,last_name from " . $db->prefix . "admin where id = '" . $msg['replyingadmin'] . "'");

                                          $admin = DB::table("users")->where("id",$msg->replyingadmin)->first();



                                         $reply_by = $admin->name;

                                         //$reply_by = $admin['first_name'] . " " . $admin['last_name'];

                                         $reply_desg = "Staff";

                                         $class = "staff";

                                         $bg = 'style="background-color: #30a2c7;"';



                                     }

@endphp



                                <div class="room-list-block {{ $class }}" style="margin-top:20px">

                                    <div class="row">

                                        <div class="col-xs-12  col-sm-12  col-md-12  col-lg-12 room-text">

                                            <div class="margin-row">

                                                <div class="fpp-ticket " style="min-height: 170px;">

                                                    <div class="date">{{  $msg->replyingtime }}

                                                    </div>

                                                    <div class="user" style="{{ $bg }}">

                                                        <i class="fa fa-user"></i>

                                                        <span class="name">{{  $reply_by }}</span>

                                                        <span class="type">{{  $reply_desg }}</span>

                                                    </div>

                                                    <div class="message" style="padding-left: 10px;">



                                                        <p> {!!  $msg->message !!}   </p>

@if($msg->attachment!="")

                                                        <a target="_blank" href="{{  asset("storage/app/".$msg->attachment)  }}"> Attachment</a>

@endif

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>





@php



   }

@endphp



                    </li>





                    </ul>



                </div><!-- end columns -->





            </div>

        </div><!-- end container -->

        </div><!-- end room-listing-blocks -->



    </section>





@endsection

@section("footer-script")





@endsection

