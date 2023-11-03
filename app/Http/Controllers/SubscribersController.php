<?php



namespace App\Http\Controllers;



use App\airport;

use App\subscribers;

use App\partners;

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
        // dd($request);

        set_time_limit(0);



        $agents = partners::all();
        $agentlist = [];
        $agentlist[""] = "Select Agent";
         foreach ($agents as $u) {

            $agentlist[$u["id"]] = $u["username"];

        }
        
        $airports = airport::all()->where("status", "Yes")->toArray();

        $airportsList = [];

        $airportsList[""] = "Select Airport";

        foreach ($airports as $u) {

            $airportsList[$u["id"]] = $u["name"];

        }

        if($request->has("downloaded"))
        {
            if($request->downloaded != "all")
            {
               
             if($request->has("agent_id"))  
            {
               $subscribers = subscribers::where("agent_id", $request->agent_id)

                        ->where("download", $request->downloaded)

                        ->paginate(30);
           }
            }
            else
            {
                 $subscribers = subscribers::where("agent_id", $request->agent_id)->paginate(30);
            }
          
        }
        else
        {
             $subscribers = subscribers::orderBy('id')->paginate(30);
        }
        
        
     
        // $subscribers = subscribers::orderBy('id')->paginate(20);





        // if ($request->has("downloaded")) {

        //     $downloaded = $request->input("downloaded");

        //     $airport_id = $request->input("agent_id");



        //     if($downloaded!="all"){

        //         if($airport_id){

        //             // $subscribers = subscribers::where("airport_id", $airport_id)

        //             //     ->where("download", $downloaded)

        //             //     ->paginate(20);

        //             $subscribers = subscribers::where("download", $downloaded)
        //             ->paginate(20);

        //             $subscribers->appends(['agent_id' => $airport_id]);

        //             $subscribers->appends(['downloaded' => $downloaded]);

        //         }else {

        //             $subscribers = subscribers::where("download", $downloaded)

        //                 ->paginate(20);

        //             $subscribers->appends(['downloaded' => $downloaded]);

        //             $subscribers->appends(['agent_id' => $airport_id]);



        //         }

        //     }else {

        //         // $subscribers = subscribers::where("airport_id",$airport_id)->paginate(20);
        //          $subscribers->appends(['agent_id' => $airport_id]);
        //         $subscribers = subscribers::paginate(20);
              

        //         // $subscribers->appends(['airport_id' => "all"]);

        //     }







        // }

        //dd($reviews->user->email);

        return view("admin.subscribers.list", ["subscribers" => $subscribers,"airportsList"=>$airportsList , 'agentlist' => $agentlist]);

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

    public function export_subscriber_excel(Request $request)
    { 

        header('Content-Type: application/vnd.ms-excel');    //define header info for browser
        header('Content-Disposition: attachment; filename=subscriberlist' . date('YmdH:i') . '.xls');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "Sr# \t Name \t Email ";
        
        print("\n");
        $i = 1;
        $subscribers = subscribers::orderBy('id')->get();
        
        foreach ($subscribers as $row) {
            
            $output = $i . "\t";
            $output .= $row->name . "\t";
            $output .= $row->email . "\t";

            print(trim($output)) . "\t\n";
            $i++;
        }

    }
}

