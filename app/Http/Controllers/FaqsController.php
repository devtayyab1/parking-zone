<?php

namespace App\Http\Controllers;

use App\users_roles;
use App\faqs;
use App\airport;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $faqs = new faqs;
         $id =  Auth::user()->id;
         $assigned_agent =  \App\users_roles::where(['user_id' => $id])->first();
                    $agents = $assigned_agent->assigned_agents;
                    $agent = explode(",",$agents);
                     if(isset($agent[0]))
                      {
                         if (in_array("0", $agent))
                         {
                           $faqs =   DB::table('faqs')->get();
                          
                         }
                         else
                         {
                        if (in_array("1", $agent))
                        {
                            $faqs = faqs::where('agent_id' , '1');
                        }
                     
                        if (in_array("2", $agent))
                        {
                            $faqs = faqs::where('agent_id' , '2');
                        }
                        if (in_array("3", $agent))
                        {
                            $faqs = faqs::where('agent_id' , '3');
                        }
                        if (in_array("4", $agent))
                        {
                          $faqs = faqs::where('agent_id' , '4');
                        }
                        if (in_array("5", $agent))
                        {
                            $faqs = faqs::where('agent_id' , '5');
                        }
                         }
                       
                    }
                    else
                    {
                         if ($agent = "1")
                        {
                          $faqs = faqs::where('agent_id' , '1');
                        }
                        if ($agent = "2")
                        {
                          $faqs = faqs::where('agent_id' , '2');
                        }
                      if ($agent = "3")
                        {
                          $faqs = faqs::where('agent_id' , '3');
                        }
                        if ($agent = "4")
                        {
                         $faqs = faqs::where('agent_id' , '4');
                        }
                        if ($agent = "5")
                        {
                         $faqs = faqs::where('agent_id' , '5');
                        }
                        $faqs =  $faqs->get();
                    }
         
        
        
        
        //dd($reviews->user->email);
        return view("admin.faqs.list", ["faqs" => $faqs]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //dd($reviews->user->email);
         $agentsList = array("0" => "All",
        "1"=>"ParkingZone",
        "2"=>"YayParking",
        "3"=>"Zairport",
        "4"=>"Travelez",
        "5"=>"EzTrip");
        
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        $airports = airport::all();
         
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
         
        return view("admin.faqs.create" , ["user_role_agents" => $user_role_agents , "agentsList" => $agentsList , "airports" => $airports]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $agent =  $request->input("agentID");
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
        
        if($agent == '0')
        {
        if(!in_array(0,$user_role_agents))
         {
            $agent =  $user_role_agents[0];
         }
         else
         {
             return redirect()->back()->with('erroragent', 'Please Select Specific Agent');
         }
        }
        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'content' => 'required|string'
        ], $messages);


        $faq = new faqs();
        $faq->title = $request->input("title");
        $faq->type = $request->input("type");
        $faq->content = $request->input("content");
        $faq->agent_id = $agent;
        $faq->airport_id = $request->input("airportID"); 
        $faq->status = $request->input("status");
        
        
        if ($faq->save()) {
            return redirect(route("faqs.index"))->with('success', 'Data Inserted  successfully');
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function show(faqs $faqs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $faq = faqs::findOrFail($id);
         $agentsList = array("0" => "All",
        "1"=>"ParkingZone",
        "2"=>"YayParking",
        "3"=>"Zairport",
        "4"=>"Travelez",
        "5"=>"EzTrip");
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        $airports = airport::all();
         
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
        
       
        return view("admin.faqs.edit", ["user_role_agents" => $user_role_agents , "agentsList" => $agentsList ,"faq" => $faq , "airports" => $airports]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       
        $faqs = faqs::findOrFail($id);

        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'content' => 'required|string'
        ], $messages);


        //$page = [];
        $faqs["title"] = $request->input("title");
        $faqs["type"] = $request->input("type");
        $faqs["content"] = $request->input("content");
        $faqs["status"] = $request->input("status");
        $faqs["airport_id"] = $request->input("airportID"); 


        if ($faqs->update()) {
            return redirect(route("faqs.index"))->with('success', 'Data updated  successfully');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $aid = $id;
        $d = DB::table('faqs')->where('id', $aid)->delete();

        return redirect(route("faqs.index"))->with('success', 'Information Deleted successfully');
    }
}
