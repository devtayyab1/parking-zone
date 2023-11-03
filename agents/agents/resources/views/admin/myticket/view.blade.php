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

    <style type="text/css">
        .awards-pic {
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .awards-pic img {
            width: 80px;
        }

        .leftText {
            margin-top: 10px;
        }

        .pad0 {
            padding: 0px;
        }
    </style>
@endsection
@section('content')

    <div class="alert alert-primary">
        <button type="button" class="close" data-dismiss="alert">×</button>

    </div>

    <style>
        p {
            padding-left: 15px;
        }

        h3 {
            padding-left: 15px;
        }
    </style>

    <div class="page-content">


        <div class="page-header">
            <ol class="breadcrumb bc-3">
                <li><a href="index.php"><i class="fa fa-home"></i>Dashboad</a></li>
                <li><strong>Support</strong></li>
                <li class="active"><strong>Support Ticket</strong></li>
            </ol>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="col-md-6">
                        <h2>Title</h2>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-9">
                        <br>
                        <div Displayclass="alert alert-danger text-center">

                        </div>

                        <div class="accordion" id="accordion2">
                            <div style="border: 1px solid #428bca;" class="accordion-group" id="ticketReply">
                                <div style="    background: #428bca;
    height: 51px;" class="accordion-heading">
                                    <a style="font-size: 30px !important;    color: #f5f5f5;" class="accordion-toggle" data-toggle="collapse"
                                       data-parent="#accordion2" href="#collapse11"><i class="fa fa-pencil-square-o"
                                                                                       aria-hidden="true"></i> Reply</a>
                                </div>
                                <div id="collapse11" class="accordion-body collapse passenger-detail">
                                    <div class="accordion-inner">
                                        <form method="post" action="{{ route("submit-reply") }}" class="contact-form"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <input type="hidden" name="reply_by" value="Admin">
                                            <input type="hidden" name="ticket_ref" value="{{ $ticket->ticket_id }}">
                                            @php
                                            $a_id=Auth::user()->id;
                                            @endphp
                                            <input type="hidden" name="replyingadmin" value="{{ $a_id }}">

                                            {{--<div class="row" style="display:none;">--}}
                                            {{--<div class="col-sm-4">--}}
                                            {{--<label for="inputName">Name</label>--}}
                                            {{--<input class="form-control" type="text" value="{{ $ticket->ticket_id }}" readonly>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-5">--}}
                                            {{--<label for="inputEmail">Email Address</label>--}}
                                            {{--<input class="form-control" type="text" value="{{ $ticket->ticket_id }}" readonly>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="form-group">
                                                <label for="inputMessage">Message</label>
                                                <textarea name="message" id="message" rows="12"
                                                          class="form-control ckeditor">
									
									</textarea>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label for="inputAttachments">Attachments</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="file" name="attatchment" class="form-control">

                                                </div>

                                                <div class="col-xs-12 ticket-attachments-message text-muted">
                                                    Allowed File Extensions: .jpg, .gif, .jpeg, .png
                                                </div>
                                            </div>

                                            <label class="radio-inline">
                                                <input type="radio" name="reply_to" value="All">Send All
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="reply_to" value="Client" checked>Send to
                                                Customer
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="reply_to" value="Company">Send to Company
                                            </label>

                                            <div class="form-group text-center">
                                                <input class="btn btn-success" type="submit" name="reply_ticket"
                                                       value="Submit">
                                                <input class="btn btn-danger" type="reset" value="Cancel"
                                                       onclick="jQuery('#ticketReply').click()">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="margin-row ">
                            <div class="fpp-ticket " style="min-height: 40px;">
                                <h1 style="text-align: center">Messages</h1>
                            </div>
                        </div>


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
                                                                 $css = "margin-top: 20px;
    border: 1px solid #ccc;
    padding: 20px;
    background: #f6e8e8;";
                                                             } elseif ($msg->reply_by == "Company") {
                                                                // $admin = $db->get_row("select first_name,last_name from " . $db->prefix . "admin where id = '" . $ticket['company_admin_id'] . "'");
                                                                // $reply_by = $admin['first_name'] . " " . $admin['last_name'];

                                                                 $user = DB::table("users")->where("id",$ticket->company_admin_id)->first();

                                                                 $reply_by = $user->name;

                                                                 $reply_desg = "Company";
                                                                 $class = "companies";
                                                                 $bg = 'style="background-color: #fa6541;"';
                                                             } else {
                                                             $css = "margin-top: 20px;
    border: 1px solid #ccc;
    padding: 20px;
    background: #bd9de0;
    margin-right:116px;
    margin-left: -40px;";
                                                                // $admin = $db->get_row("select first_name,last_name from " . $db->prefix . "admin where id = '" . $msg['replyingadmin'] . "'");
                                                                  $admin = DB::table("users")->where("id",$ticket->replyingadmin)->first();

                                                                 //$reply_by = $admin->name;
                                                                 $reply_by = ""; if($admin) {  $reply_by = $admin->name; }
                                                                 //$reply_by = $admin['first_name'] . " " . $admin['last_name'];
                                                                 $reply_desg = "Staff";
                                                                 $class = "staff";
                                                                 $bg = 'style="background-color: #30a2c7;"';

                                                             }
                        @endphp
                        <div class="room-list-block {{ $class }}"
                             style="margin-top:20px; border: 1px solid #ccc;padding: 20px; {{ $css }}">
                            <div class="row">
                                <div class="col-xs-12  col-sm-12  col-md-12  col-lg-12 room-text">
                                    <div class="margin-row">
                                        <div class="fpp-ticket ">
                                            <div class="date">{{  $msg->replyingtime }}
                                            </div>
                                            <div class="user" style="{{ $bg }}">
                                                <i class="fa fa-user"></i>
                                                <span class="name">{{  $reply_by }}</span>
                                                <span class="type">{{  $reply_desg }}</span>
                                            </div>
                                            <div class="message" style="padding-left: 10px;">

                                                <p>{{  $msg->message }}</p>




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


                    </div>


                    <div class="col-md-3" style="padding-top: 19px;">

                        <div style="    border: 1px solid black;" class="panel panel-dark" data-collapsed="0">
                            <div style="    background: #5d5959;" class="panel-heading">
                                <div class="panel-title">Ticket Information</div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <th class="col-md-6">Reference</th>
                                        <td id="discount_price_txt" class="col-md-6">{{ $ticket->ticket_id }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Booking Reference</th>
                                        <td id="discount_price_txt" class="col-md-6">{{ $ticket->booking_ref }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Status</th>
                                        <td class="col-md-5">
                                            <span class="status status"> </span>


                                            <a href="" class="btn btn-danger btn-xs" title="Close Ticket"><i
                                                        class="entypo-cancel-circled"></i>{{ $ticket->status }}</a>

                                            {{--<a href="" class="btn btn-success btn-xs" title="Re Open Ticket"><i--}}
                                            {{--class="entypo-check"></i></a>--}}

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Created</th>
                                        <td class="col-md-5">{{ $ticket->date  }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Current Progress</th>
                                        <td class="col-md-5"><strong class="badge badge" style="font-size:10px !important;">

                                                {{ $companyMsg }}
                                            </strong></td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Department</th>
                                        <td id="booking_fee_txt" class="col-md-5">{{ $department->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Assign to</th>
                                        <td id="booking_fee_txt" class="col-md-5">

                                            @if($ticket->agent) {{ $ticket->agent->name }} @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-5">Priority</th>
                                        <td id="total_price_txt" class="col-md-5">{{ $ticket->urgency  }}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="     border: 1px solid black;" class="panel panel-dark" data-collapsed="0">
                            <div style="    background: #5d5959;" class="panel-heading">
                                <div class="panel-title">Special Notes</div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <div class="margin-row ">
                                    <div class="fpp-ticket-sidebar scrools">
                                        <div id="notes" class="notes" style="height: 300px;
    overflow-y: scroll;
    border: 1px solid #ccc;
    margin-bottom: 10px;">


                                            @php
                                                $notes = \App\ticket_notes::where("ticket_id",$ticket->id)->orderBy("id","desc")->get();
                                                                                                   //dd($chat);

                                                                                                   foreach ($notes as $msg) {



                                            @endphp

                                            <div class="room-list-block"
                                                 style="margin-top: 5px;
    border: 1px solid #ccc;
    padding: 5px;
    margin-left: 2px;">
                                                <div class="row">
                                                    <div class="col-xs-12  col-sm-12  col-md-12  col-lg-12 room-text">
                                                        <div class="margin-row">
                                                            <div class="fpp-ticket ">

                                                                {{--<div class="user" style="{{ $bg }}">--}}
                                                                {{--<i class="fa fa-user"></i>--}}
                                                                {{--<span class="name">{{  $reply_by }}</span>--}}
                                                                {{--<span class="type">{{  $reply_desg }}</span>--}}
                                                                {{--</div>--}}
                                                                <div class="message">

                                                                    <p>{{  $msg->note }}</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            @php

                                                }
                                            @endphp

                                        </div>
                                    </div>
                                </div>
                                <div class="margin-row ">
                                    <form method="post" action="{{ route("addNote") }}">
                                        <input type="hidden" name="tid" value="{{ $ticket->id }}">

                                        <div class="fpp-ticket-sidebar text-right">
                                        <textarea class="form-control autogrow" required id="messagez" name="note"
                                                  placeholder="Write your Special note here about ticket....."
                                                  style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"></textarea>
                                            <br>
                                            <button type="submit" id="message_submit"
                                                    class="btn btn-green btn-icon icon-left"> Send Message <i
                                                        class="entypo-check"></i></button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<script src='{{ secure_asset("assets/js/jquery.validate.min.js") }}'></script>--}}
                {{--<script src='{{ secure_asset("assets/js/fileinput.js") }}'></script>--}}
                {{--<script src='{{ secure_asset("assets/js/ckeditor/ckeditor.js") }}'></script>--}}
                {{--<script src='{{ secure_asset("assets/js/datatables/datatables.js") }}'></script>--}}

                <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {

                        $('#message').summernote({
                            height: 150,
                            disableDragAndDrop: true,
                            toolbar: [
// [groupName, [list of button]]
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']]
                            ]
                        });
                    });

                    //                    var interval = 1000;  // 1000 = 1 second, 3000 = 3 seconds
                    //                    function doAjax() {
                    //                        $.ajax({
                    //                            type: 'POST',
                    //                            url: 'increment.php',
                    //                            data: $(this).serialize(),
                    //                            dataType: 'json',
                    //                            success: function (data) {
                    //                                $('#hidden').val(data);// first set the value
                    //                            },
                    //                            complete: function (data) {
                    //                                // Schedule the next
                    //                                setTimeout(doAjax, interval);
                    //                            }
                    //                        });
                    //                    }
                    //                    setTimeout(doAjax, interval);


                </script>

@endsection