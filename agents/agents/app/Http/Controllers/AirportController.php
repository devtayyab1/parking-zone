<?php

namespace App\Http\Controllers;

use App\airport;
use App\airports_terminals;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\View\View;
use Gate;





class AirportController extends Controller
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
        set_time_limit(0);
        $airports = airport::paginate(20);
        if ($request->has("name")) {
            $name = $request->input("name");
            $airports = airport::where("name",$name)->paginate(20);
        }
        return view("admin.airport.list", ["airports" => $airports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.airport.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//print_r($request->input("terminal")); die();
        //
        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'aname' => 'required|string|max:255',
            'descp' => 'required|string',
            'address' => 'required|string',
            'town' => 'required|string',
            'postalcode' => 'required|string'
        ], $messages);
       // return $validatedData;

        $airports = new airport();
        $airports->name = $request->input("aname");
        $airports->description = $request->input("descp");
        $airports->address = $request->input("address");
        $airports->post_code = $request->input("postalcode");
        $airports->city = $request->input("town");
        $airports->status = $request->input("status");


        //file storage
        if ($request->hasFile('profile_image')) {

            $path = $request->file('profile_image')->store('companies');
            $airports->profile_image = $path;
        }

        if ($airports->save()) {
            if (count($request->input("terminal")) > 0 && !empty($request->input("terminal"))) {
                $aid = $airports->id;
                $data = [];
                $i = 0;
                //if(count($request->input("terminal")) > 0) {
                    foreach ($request->input("terminal") as $terminal) {
                        if($terminal!="") {
                            $data[] = array("aid" => $aid, "name" => $terminal);
                        }
                    }
                if(count($data)>0) {
                    DB::table('airports_terminals')->insert($data);
                }
                //}
            }
        }
      //  return  redirect()->back();
           return redirect(route("airport.index"))->with("success", "Airport Added Successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\airport $airport
     * @return \Illuminate\Http\Response
     */
    public function show(airport $airport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\airport $airport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $airport = airport::findOrFail($id);
        $terminals = airports_terminals::all()->where("aid", "=", $id);

        return view('admin.airport.edit', ["airport" => $airport, "id" => $id, "terminals" => $terminals]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\airport $airport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $airport)
    {
        //
        //dd($request);
    $airports=airport::findOrFail($airport);
   

        $messages = [
            'required' => 'This field is required.',
        ];
        $validatedData = $request->validate([
            'aname' => 'required|string|max:255',
            'descp' => 'required|string',
            'address' => 'required|string',
            'town' => 'required|string',
            'postalcode' => 'required|string'
        ], $messages);

        
        $airports["name"] = $request->input("aname");
        $airports["description"] = $request->input("descp");
        $airports["address"] = $request->input("address");
        $airports["post_code"] = $request->input("postalcode");
        $airports["city"] = $request->input("town");
        $airports["status"] = $request->input("status");


        //file storage
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('companies');
            $airports["profile_image"] = $path;
        }

          if ($airports->save()) {
            return redirect(route("airport.index"))->with("success", "Airport Updated Successfully");
        }
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\airport $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy($airport)
    {
        //
        $aid = $airport;
        DB::table('airports')->where('id', $aid)->delete();
        return redirect()->back()->with('success', 'Information Deleted successfully');

    }
}
