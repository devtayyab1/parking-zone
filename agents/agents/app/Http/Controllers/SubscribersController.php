<?php

namespace App\Http\Controllers;

use App\airport;
use App\subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscribersController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        set_time_limit(0);


        $airports = airport::all()->where("status", "Yes")->toArray();
        $airportsList = [];
        $airportsList[""] = "Select Airport";
        foreach ($airports as $u) {
            $airportsList[$u["id"]] = $u["name"];
        }

        $subscribers = subscribers::orderBy('id')->paginate(20);


        if ($request->has("downloaded")) {
            $downloaded = $request->input("downloaded");
            $airport_id = $request->input("airport_id");

            if($downloaded!="all"){
                if($airport_id){
                    $subscribers = subscribers::where("airport_id", $airport_id)
                        ->where("download", $downloaded)
                        ->paginate(20);
                    $subscribers->appends(['airport_id' => $airport_id]);
                    $subscribers->appends(['downloaded' => $downloaded]);
                }else {
                    $subscribers = subscribers::where("download", $downloaded)
                        ->paginate(20);
                    $subscribers->appends(['downloaded' => $downloaded]);
                    $subscribers->appends(['airport_id' => $airport_id]);

                }
            }else {
                $subscribers = subscribers::where("airport_id",$airport_id)->paginate(20);
                $subscribers->appends(['airport_id' => $airport_id]);
                $subscribers->appends(['airport_id' => "all"]);
            }



        }
        //dd($reviews->user->email);
        return view("admin.subscribers.list", ["subscribers" => $subscribers,"airportsList"=>$airportsList]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subscribers  $subscribers
     * @return \Illuminate\Http\Response
     */
    public function show(subscribers $subscribers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subscribers  $subscribers
     * @return \Illuminate\Http\Response
     */
    public function edit(subscribers $subscribers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subscribers  $subscribers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subscribers $subscribers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subscribers  $subscribers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $aid = $id;
        DB::table('subscribers')->where('id', $aid)->delete();
        return redirect()->back()->with('success', 'Information Deleted successfully');
    }
}
