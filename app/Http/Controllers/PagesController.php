<?php

namespace App\Http\Controllers;

use Auth;
use App\airport;
use App\pages;
use App\users_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\Storage; 

class PagesController extends Controller
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
    public function index(Request $request)
    {
        //
        // dd($request);
        $set = 0;
        $id =  Auth::user()->id;
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
      
                   $assigned_agent =  \App\users_roles::where(['user_id' => $id])->first();
                    $agents = $assigned_agent->assigned_agents;
                    $agent = explode(",",$agents);
                    
                     
              $pages = new pages();


           $airports = airport::all();

      
        if ($request->has("airport")) {
            $name = $request->input("airport");

            if ($name != "" && $name != "all") {
                $pages = $pages->where('type', '=',$name );
              
            }
        }  
        if ($request->has("agentID")) {
            $name = $request->input("agentID");
            
              if ($name != "" && $name != "all") {
                    
                          if($name == 0)
                          {
                          if(! in_array(0,$user_role_agents))
                          {
                          $name =  $user_role_agents[0];
                          }
                         else
                         {
                              $set = 1;
                          }
                          }
                    if($set == "0")
                     {
                      $pages = $pages->where('agent_id', '=',$name );
                     
                     }
                  }
                  
                 
              
            }
        
        else
        {
               if(isset($agent[0]))
                       {
                          if (in_array("0", $agent))
                          {
                              
                          }
                          else
                          {
                      
                        if (in_array("1", $agent))
                        {
                          $pages = $pages->where('agent_id', '=', '1' );
                        }
                        if (in_array("2", $agent))
                        {
                          $pages = $pages->where('agent_id', '=', '2' );
                        }
                       
                        if (in_array("3", $agent))
                        {
                          $pages = $pages->where('agent_id', '=', '3' );
                        }
                       
                        if (in_array("4", $agent))
                        {
                          $pages = $pages->where('agent_id', '=', '4' );
                        }
                        if (in_array("5", $agent))
                        {
                         $pages = $pages->where('agent_id', '=', '5' );
                        }
                          }
                        
                        
                    }
                    else
                    {
                         if ($agent = "1")
                        {
                         $pages = $pages->where('agent_id', '=', '1' );
                        }
                        if ($agent = "2")
                        {
                         $pages = $pages->where('agent_id', '=', '2' );
                        }
                       if ($agent = "3")
                        {
                         $pages = $pages->where('agent_id', '=', '3' );
                        }
                        if ($agent = "4")
                        {
                          $pages = $pages->where('agent_id', '=', '4' );
                        }
                        if ($agent = "5")
                        {
                         $pages = $pages->where('agent_id', '=', '5' );
                        }
                     
                    }
        }
        $agentsList = array("0"=>"All",
        "1"=>"ParkingZone",
        "2"=>"YayParking",
        "3"=>"Zairport",
        "4"=>"Travelez",
        "5"=>"EzTrip");

      if ($request->has("name")) {
            $name = $request->input("name");
            // $pages = $pages
            // ->where('page_title', 'like', '%' . $name . '%')
            // ->orWhere('slug', 'like', '%' . $name . '%');
                $pages =$pages->where(function ($pages) use ($name) {
                $pages = $pages->where('page_title', 'like', '%' . $name . '%');
                $pages =  $pages->orWhere('slug', 'like', '%' . $name . '%'); 
               // dd("paid");
            });
     }



        $pages = $pages->get();
        return view("admin.text_pages.list", ["pages" => $pages,"airports" => $airports , "agentsList" => $agentsList , "user_role_agents" => $user_role_agents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $id =  Auth::user()->id;
        $airports = airport::all()->where("status", "Yes")->toArray();

        $airportsList = [];
       
        foreach ($airports as $u) {
            $airportsList[$u["id"]] = $u["name"];
        }
         $agentsList = array("0" => "All",
        "1"=>"ParkingZone",
        "2"=>"YayParking",
        "3"=>"Zairport",
        "4"=>"Travelez",
        "5"=>"EzTrip");
        
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
        return view("admin.text_pages.create", ["airportsList" => $airportsList , "user_role_agents" => $user_role_agents , "agentsList" => $agentsList]);
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
        //  dd($request);
         $agent =  $request->input("agentID");
        $user_role_details = users_roles::where('user_id',Auth::user()->id)->first()->toArray();
        if($user_role_details)
        {
            $user_role_src =explode(",",$user_role_details["bk_source"]);
            $user_role_agents =explode(",",$user_role_details["assigned_agents"]);
        }
         if(! in_array(0,$user_role_agents))
         {
            $agent =  $user_role_agents[0];
         }
         else
         {
             return redirect()->back()->with('erroragent', 'Please Select Specific Agent');
         }
        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'page_title' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_keyword' => 'required|string',
            'type'=>'required',
            'meta_description' => 'required|string'
        ], $messages);

       
        //  dd($agent);
        $page = new pages();

        $page->page_title = $request->input("page_title");
        $page->meta_title = $request->input("meta_title");
        $page->meta_keyword = $request->input("meta_keyword");
        $page->meta_description = $request->input("meta_description");
        $page->type = $request->input("type");
        $page->agent_id = $request->input("agentID");
        
        if($request->input("airport_parking")!="") {
            $page->airport_parking = $request->input("airport_parking");
        }
        if($request->input("parking_options")!="") {
            $page->parking_options = $request->input("parking_options");
        }
        if($request->input("overview")!="") {
            $page->overview = $request->input("overview");
        }
        if($request->input("facilities")!="") {
            $page->facilities = $request->input("facilities");
        }
        if($request->input("topthings")!="") {
            $page->topthings = $request->input("topthings");
        }
        
        if($request->input("airport_id")!="") {
            $page->typeid = $request->input("airport_id");
        }
		if ($request->hasFile('logo')) {            $path = $request->file('logo')->store('pages');            $page->logo = $path;        }



        $page->status = $request->input("status");

        $page->meet_and_greet = $request->input("meet_and_greet");
        $page->park_and_ride = $request->input("park_and_ride");
        $page->alluring = $request->input("alluring");
        $page->alluring_onairport = $request->input("alluring_onairport");
        $page->alluring_meetandgreet = $request->input("alluring_meetandgreet");
        $page->alluring_parkandride = $request->input("alluring_parkandride");

        $page->slug = $this->createSlug($request->input("page_title"));

        if ($page->save()) {
            return redirect(route("pages.index"))->with('success', 'Page added  successfully');
        }


    }


    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Pages::select('pages.*')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pages $pages
     * @return \Illuminate\Http\Response
     */
    public function show(pages $pages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pages $pages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $page = pages::findOrFail($id);
        $airports = airport::all()->where("status", "Yes")->toArray();

        $airportsList = [];
        foreach ($airports as $u) {
            $airportsList[$u["id"]] = $u["name"];
        }
        return view("admin.text_pages.edit", ["page" => $page, "airportsList" => $airportsList]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\pages $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $page = pages::findOrFail($id);

        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'page_title' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string'
        ], $messages);


        //$page = [];
        $page["page_title"] = $request->input("page_title");
        $page["meta_title"] = $request->input("meta_title");
        $page["meta_keyword"] = $request->input("meta_keyword");
        $page["meta_description"] = $request->input("meta_description");
        $page["type"] = $request->input("type");
        if($request->input("airport_parking")!="") {
            $page->airport_parking = $request->input("airport_parking");
        }
        if($request->input("parking_options")!="") {
            $page->parking_options = $request->input("parking_options");
        }
        if($request->input("overview")!="") {
            $page->overview = $request->input("overview");
        }
        if($request->input("facilities")!="") {
            $page->facilities = $request->input("facilities");
        }
        if($request->input("topthings")!="") {
            $page->topthings = $request->input("topthings");
        }
        
        if($request->input("airport_id")!="") {
            $page["typeid"] = $request->input("airport_id");
        }
        $page["status"] = $request->input("status");
        $page["schema_pz"] = $request->input("Schema");
        $page["meet_and_greet"] = $request->input("meet_and_greet");
        $page["park_and_ride"] = $request->input("park_and_ride");
        $page["alluring"] = $request->input("alluring");
        $page["alluring_onairport"] = $request->input("alluring_onairport");
        $page["alluring_meetandgreet"] = $request->input("alluring_meetandgreet");
        $page["alluring_parkandride"] = $request->input("alluring_parkandride");
		if ($request->hasFile('logo')) {

            $path = $request->file('logo')->store('pagebanners');

            $page["banner"] = $path; 
			

        }		
        //$pages->slug = $this->createSlug($request->input("page_title"));


        if ($page->update()) {
            return redirect(route("pages.index"))->with('success', 'Page updated  successfully');
        }


        //update


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $aid = $id;
        DB::table('pages')->where('id', $aid)->delete();
        return redirect(route("pages.index"))->with('success', 'Information Deleted successfully');
    }
}
