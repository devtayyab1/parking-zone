<?php

namespace App\Http\Controllers;

use App\airport;
use App\Company;
use App\support_departments;
use App\ticket_chat;
use App\tickets;
use App\airports_bookings;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mockery\Exception;


class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $airports = airport::all()->where("status", "Yes");
        $departementslist = support_departments::all()->toArray();
        $departements_list = [];
        $departements_list[""] = "Select Department";
        foreach ($departementslist as $u) {
            $departements_list[$u["id"]] = $u["name"];
        }

        return view("frontend.customer_support", ["airports" => $airports, "departements_list" => $departements_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        $messages = [
            'required' => 'This field is required.',
            'attatchment.max' => 'The document may not be greater than 2 megabytes'
        ];
        $validatedData = Validator::make(Input::all(), [
            'ref_no' => 'required|string|max:255',
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact' => 'required',
            'department' => 'required',
            'priority' => 'required',
            'subject' => 'required',
            'message' => 'required|string',
            'supportdeskpolicy' => 'required',
            'attatchment' => 'mimes:jpeg,bmp,png|max:2000' //2mb file can be uploaded
        ], $messages);


        $booking = airports_bookings::where("referenceNo", $request->input("ref_no"))
            ->where("email", $request->input("email"))->first();


        if ($booking) {
            $company = Company::where("id", $booking->companyId)
                ->orWhere("aph_id", $booking->companyId)->first();


            $ticket = new tickets();
            $ticket->title = $request->input("subject");
            $ticket->booking_ref = $request->input("ref_no");
            $ticket->user_id = $booking->customerId;
            $ticket->company_admin_id = $company->admin_id;
            $ticket->name = $request->input("full_name");
            $ticket->email = $request->input("email");
            $ticket->contact = $request->input("contact");
            $ticket->department = $request->input("department");
            $ticket->urgency = $request->input("priority");
            $ticket->date = date("Y-m-d h:i:s");
            $ticket->status = "open";

            if ($ticket->save()) {
                $tid = DB::getPdo()->lastInsertId();
                $ticketRef = "PZT" . date("dmy") . $tid;
                $model = tickets::find($tid);
                $model->ticket_id = $ticketRef;
                $model->save();

                $path = "";
                if ($request->hasFile('attatchment')) {

                    $path = $request->file('attatchment')->store('supports');
                    // $ticket->file = $path;
                }
                $data = [
                    "message" => $request->input("message"),
                    "attachment" => $path,
                    "clientunread" => "No",
                    "adminunread" => "Yes",
                    "replyingtime" => date("Y-m-d h:i:s"),
                    "replyingadmin" => $booking->customerId,
                ];
                if ($ticket->chat()->create($data)) {
                    $tickref = Crypt::encrypt($ticketRef);


                    $email = new  EmailController();

                    //$tickref = Crypt::encrypt($request->input("ref_no"));
                    $link ="https://www.parkingzone.co.uk/ticket/view/".$tickref;

                    $template_data = [];
                    $template_data["username"] =$request->input("full_name");
                    $template_data["link"] =$link;
                    $template_data["subject"] =$request->input("subject");
                    $template_data["urgency"] =$request->input("priority");
                    $template_data["status"] ="open";
                    $template_data["urgency"] =$ticket->title;
                    $template_data["ticket_ref"] =$request->input("ref_no");
                    $template_data["msg"] =$request->input("message");

                    $department = support_departments::where("id",$request->input("department"))->first();
                     $toEmail=  $department->email;
                    $email->sendEmail("ticket_reply_client",$toEmail,$template_data);


                    //email send to client
                    $email->sendEmail("ticket_reply_client",$request->input("email"),$template_data);



                    return redirect(route("view-ticket", ["id" => $tickref]));
                }
            }
        } else {
            $validatedData->getMessageBag()->add('ref_no', 'Invalid Data Entered');
        }

        return redirect()->back()->withErrors($validatedData, 'ticket_store')->withInput();


        //return $validatedData;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tickets $tickets
     * @return \Illuminate\Http\Response
     */
    public function show(tickets $tickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tickets $tickets
     * @return \Illuminate\Http\Response
     */
    public function edit(tickets $tickets)
    {
        //
    }

    public function submit_reply(Request $request)
    {

        $messages = [
            'required' => 'This field is required.',
            'attatchment.max' => 'The document may not be greater than 2 megabytes'
        ];

        $validatedData = Validator::make(Input::all(), [
            'ticket_id' => 'required|string|max:255',
            'replyingadmin' => 'required|string',
            'ticket_ref' => 'required|string',
            // 'contact' => 'required',
            //'department' => 'required',
            //'priority' => 'required',
            //'subject' => 'required',
            'message' => 'required|string',
            'attatchment' => 'mimes:jpg,jpeg,bmp,png|max:2000' //2mb file can be uploaded
        ], $messages);

        $path = "";
        if ($request->hasFile('attatchment')) {

            $path = $request->file('attatchment')->store('supports');
            // $ticket->file = $path;
        }


        $data = [
            "message" => $request->input("message"),
            "ticket_id" => $request->input("ticket_id"),
            "attachment" => $path,
            "clientunread" => "No",
            "adminunread" => "Yes",
            "replyingtime" => date("Y-m-d H:i:s"),
            "replyingadmin" => $request->input("replyingadmin"),
            "reply_by" => $request->input("reply_by"),
        ];
        if (count($validatedData->errors()->messages())>0) {
            //var_dump($validatedData->errors());
            return redirect()->back()->withErrors($validatedData)->withInput();
        } else {
            $chat_data = ticket_chat::create($data);
            if ($chat_data) {
                $ticket = tickets::where("ticket_id",$request->input("ticket_ref"))->first();

               // dd($ticket);
                $tickref = Crypt::encrypt($request->input("ticket_ref"));
                $link ="https://www.parkingzone.co.uk/ticket/view/".$tickref;
                $email = new  EmailController();

                $template_data = [];
                $template_data["username"] =$request->input("name");
                $template_data["link"] =$link;
                $template_data["subject"] =$ticket->title;
                $template_data["ticket_ref"] =$request->input("ticket_ref");
                $template_data["msg"] =$request->input("message");

                if($request->input("reply_by") == "Client" ) {

                    if($ticket->assign_to == 0) {
                        $department = support_departments::where("id",$ticket->department)->first();
                        $toEmail=  $department->email;
                    }else {
                        $user = User::where("id",$ticket->assign_to)->first();
                        $toEmail=  $user->email;
                    }
                    $email->sendEmail("ticket_reply_client",$toEmail,$template_data);

                }else{

                    $toEmail = $ticket->email;

                    $email->sendEmail("ticket_reply_company",$toEmail,$template_data);
                }

                return redirect()->back();
            }
        }


    }

    public function view($id)
    {

        $id = Crypt::decrypt($id);
        $ticket = tickets::where("ticket_id", $id)->orderBy('id', 'desc')->first();

        $department = support_departments::where("id", $ticket->department)->orderBy('id', 'desc')->first();
        $progress = ticket_chat::where("ticket_id", $ticket->id)->orderBy('id', 'desc')->first();
        $companyMsg = "";
        if ($progress->reply_to == 'All') {
            if ($progress->clientunread == 'Yes') {
                $companyMsg = "Awaiting for Client Read";
            } elseif ($progress->Companyread == 'No') {
                $companyMsg = "Awaiting for Company Read";
            } else {
                $companyMsg = "Awaiting for Client and Company Response";
            }
        } elseif ($progress->reply_to != 'All') {
            if ($progress->reply_by == 'Client' && $progress->hold == 'Yes') {
                $companyMsg = "Awaiting for admin to show to Company";
            } else if ($progress->reply_by == 'Company' && $progress->hold == 'Yes') {
                $companyMsg = "Awaiting for Admin to show to Client";
            } elseif ($progress->reply_by == 'Admin' && $progress->reply_to == 'Company') {
                $companyMsg = "Awaiting for Company Reply";
            } elseif ($progress->reply_by == 'Admin' && $progress->reply_to == 'Client') {
                $companyMsg = "Awaiting for Client Reply";
            } else {
                $companyMsg = "Awaiting for Response";
            }
        }


        $airports = airport::all()->where("status", "Yes");

        return view("frontend.viewticket", ["companyMsg" => $companyMsg, "progress" => $progress, "id" => $id, "airports" => $airports, "model" => $ticket, "ticket" => $ticket, "department" => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\tickets $tickets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tickets $tickets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tickets $tickets
     * @return \Illuminate\Http\Response
     */
    public function destroy(tickets $tickets)
    {
        //
    }


    public function search_ticket(Request $request)
    {
        //

        $validatedData = Validator::make(Input::all(), [
            'email' => 'required|string|max:255',
            'ref_no' => 'required|string'
        ]);


        $booking = tickets::where("ticket_id", $request->input("ref_no"))->where("email", $request->input("email"))->first();


        if ($booking) {
            $ticketRef = $booking->ticket_id;
            $tickref = Crypt::encrypt($ticketRef);
            return redirect(route("view-ticket", ["id" => $tickref]));

        } else {
            $validatedData->getMessageBag()->add('ref_no', 'Invalid Data Entered');
        }

        return redirect()->back()->withErrors($validatedData, 'search_ticket')->withInput();
    }
}
