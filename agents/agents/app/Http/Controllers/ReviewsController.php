<?php

namespace App\Http\Controllers;

use App\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    //

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
        set_time_limit(0);
        $reviews = reviews::orderBy('id')->paginate(20);
        //dd($reviews->user->email);
        return view("admin.reviews.list", ["reviews" => $reviews]);
    }


}
