<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;


use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\airport;
use App\users_roles;
use App\airports_bookings;
use App\booking_transaction;
use App\Company;
use App\User;
use App\customers;
use App\modules_settings;
use App\penalty_details;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Elibyy\TCPDF\Facades\TCPDF;


class BookingController extends Controller
{
    public $_setting = [];

    public function __construct()
    {
        $this->middleware('auth');
        $modules_settings = modules_settings::all();
        foreach ($modules_settings as $setting) {
            $this->_setting[$setting->name] = $setting->value;
        }
    }




/******Dashboard***/

    function get_sales_count($_email_booking_source){

        $count_email_booking_source = new airports_bookings();
        $count_email_booking_source = $count_email_booking_source->where("booking_status","Completed");
        $count_email_booking_source = $count_email_booking_source->where("payment_status","success");
        $count_email_booking_source = $count_email_booking_source->where("removed","No");
        $count_email_booking_source = $count_email_booking_source->where("status","Yes");


        if($_email_booking_source=="paid"){

            $count_email_booking_source = $count_email_booking_source->where(function ($count_email_booking_source) {

                $count_email_booking_source = $count_email_booking_source->where("traffic_src", "=", "ppc");
                $count_email_booking_source->whereIn("traffic_src",  "BING", "OR");

            });

        }

        if($_email_booking_source=="org"){
            $count_email_booking_source = $count_email_booking_source->where("traffic_src","ORG");
        }

        if($_email_booking_source=="em"){
            $count_email_booking_source = $count_email_booking_source->where("traffic_src","EM");
        }

        if($_email_booking_source=="ppc"){
            $count_email_booking_source = $count_email_booking_source->where("traffic_src","PPC");
        }

        if($_email_booking_source=="BING"){
            $count_email_booking_source = $count_email_booking_source->where("traffic_src","BING");
        }


        $count_email_booking_source = $count_email_booking_source->where(DB::raw(DATE_FORMAT(b.createdate, '%Y-%m-%d')),"CURDATE()");
        $count_email_booking_source = $count_email_booking_source->count();
        return $count_email_booking_source;

    }




/******* Dashboard end ************/



    function admin_booking_report_pdf (){



        // set document information
$pdf =  new TCPDF();
        $pdf::SetCreator(PDF_CREATOR);
        $pdf::SetAuthor('');
        $pdf::SetTitle('');
        $pdf::SetSubject('');
        $pdf::SetKeywords('');
        dd("testing pdf");

    }


    public function admin_booking_report_excel(Request $request)
    {
        $data = $request->all();
        $total_planty_to_company = 0;
        $total_planty_to_fly = 0;
        $total = 0;
        $lprice = 0;
        $aprice = 0;
        $commission_price = 0;
        $allrefund = 0;
        $cancelled = 0;
        $discount = 0;
        $can_count=0;
$ref_count=0;

        $filter_search = "";
        $planty_refund = " ";
        $b_t_table = " ";
        $_refund_via_s = "";
        $palenty_to = "";
        $search = "";
        $join = "";
        $planty_refund = "left join booking_transaction as bt on bt.referenceNo = b.referenceNo ";
        $b_t_table = "bt.*, ";
        if ($data != null && count($data) > 0) {

            if (!empty($data['search'])) {
                $search = trim(preg_replace('/\s+/', ' ', $data['search']));
                $search = " and (b.referenceNo like '%" . $search . "%' or b.first_name like '%" . $search . "%' or b.last_name like '%" . $search . "%' or  b.deptFlight like '%" . $search . "%' or  b.returnFlight like '%" . $search . "%')";
            }

            if (!empty($data['airport']) && $data['airport'] == "all") {
                $_airport = "";
            } else {
                $_airport = " AND b.airportID = '" . $data['airport'] . "'";
            }

            if (!empty($data['companies']) && $data['companies'] == "all") {
                $_companies = "";
            } else {
                $_companies = " AND b.companyId = '" . $data['companies'] . "'";
            }

            if (!empty($data['admins']) && $data['admins'] == "all") {
                $_admins = "";
            } else {
                $_admins = " AND c.admin_id = '" . $data['admins'] . "'";
            }

            if (!empty($data['payment']) && $data['payment'] == "all") {
                $_payment = "";
            } else {
                $_payment = " AND b.payment_method = '" . $data['payment'] . "'";
            }

            if (!empty($data['status']) && $data['status'] == "all") {
                $_status = "";
            } else {
                if ($data['status'] == 'Booked') {
                    $_status = " AND (b.booking_action = 'Booked' OR b.booking_action = 'Amend')";
                } elseif ($data['status'] == 'Refund') {

                    if ($data['refund_via'] == 'all') {
                        $_refund_via_s = "";
                    } else {
                        $_refund_via_s = " AND bt.payment_medium = '" . $data['refund_via'] . "'";
                    }
                    if ($data['palenty_to'] == 'all') {
                        $palenty_to = "";
                    } else {
                        $palenty_to = " AND bt.palenty_to = '" . $data['palenty_to'] . "'";
                    }


                    $_status = " AND b.booking_action = '" . $data['status'] . "'";

                } else {
                    if ($data["status"] != "") {
                        $_status = " AND b.booking_action = '" . $data['status'] . "'";
                    } else {
                        $_status = "";
                    }
                }
            }
            // if($request->input('filter')==null) {   $data['filter'] = 'createdate'; }
            if (isset($data['filter']) && $data['filter'] == "all") {
                $_filter = "";
            } else {
                $from = date("'Y-m-d'", strtotime($data['start_date']));
                $to = date("'Y-m-d'", strtotime($data['end_date']));
                $date_format = " DATE_FORMAT(b." . $data['filter'] . ",'%Y-%m-%d')";
                $_filter = " AND " . $date_format . " BETWEEN " . $from . " AND " . $to;
            }
            $filter_search = $search . $_airport . $_admins . $_payment . $_companies . $_status . $_refund_via_s . $palenty_to . $_filter;
        } else {
            $_current = " and b.created_at  >= CURDATE()";
            $filter_search = $_current;
        }


        $companies = "SELECT $b_t_table b.id as booking_id,b.model,b.make,b.color,b.registration ,b.referenceNo,b.booking_amount, b.booking_status, b.payment_method,b.email, b.cancelfee, b.booked_type, b.payment_method, c.share_percentage, c.name As company_name,c.company_code, b.extra_amount, a.name as airport_name, b.last_name As Surname, b.created_at AS createdate, b.departDate AS start_date, 
	 b.returnDate AS end_date, b.no_of_days, b.registration, b.make, b.model, b.color, b.phone_number,
	b.discount_amount, b.total_amount, b.booking_amount, (b.booking_amount - (c.share_percentage/100*(b.booking_amount)) ) As company_commission, 
	(c.share_percentage/100*(b.booking_amount)) As fly_commission 		
	FROM airports_bookings as b 
	left join companies as c on (b.companyId = c.id OR b.companyId = c.aph_id) 
	join airports as a on a.id = b.airportID
	$planty_refund
	WHERE  b.booking_status != 'Abandon' and b.booking_status != 'Pending' and b.removed = 'No' and b.status = 'Yes' $join $filter_search GROUP BY b.referenceNo ORDER BY b.id DESC";




        $companies = DB::select(DB::raw($companies));
        $companies = collect($companies)->map(function ($x) {
            return (array)$x;
        })->toArray();


        header('Content-Type: application/vnd.ms-excel');    //define header info for browser
        header('Content-Disposition: attachment; filename=bookinglist' . date('Ymd') . '.xls');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "Sr# \t Reference No \t Carpark Name \t Name \t Status \t Payment Method \t Booked Date \t Departures Date \t Arrival Date \t Total Days  \t Total Amount \t Vehicle make \t Model \t Color \t Registration  ";
       // echo "Sr# \t Reference No \t Carpark Name \t Name \t Status \t Payment Method \t Booked Date \t Departure Date \t Arrival Date \t Total Days  \t Cancel Amount \t Total Amount \t Vehicle make \t Model \t Color \t Registration ";

        print("\n");
        $i = 1;
        foreach ($companies as $company) {

            $cancel = 0;
            $adjust = 0;
            $transactions = booking_transaction::where("referenceNo", $company["referenceNo"]);

            $transaction = (array)$transactions;
            foreach ($transactions as $transaction) {
                if ($transaction['amount_type'] == 'credit' && $transaction['payment_case'] == 'cancel') {
                    $cancel += $transaction['payable'];
                }
                if ($transaction['amount_type'] == 'credit' && $transaction['payment_case'] == 'Refund') {
                    $adjust += $transaction['payable'];
                }
            }

            // $refund = 0;
            // if($company['booking_action'] =='Cancelled' && $company['cancelfee'] > 0){
            // $refund  = $company['booking_amount'];
            // }

            // if($company['booking_action'] =='Cancelled' && $company['cancelfee'] !=""){
            // $refund  = $company['booking_amount'];
            // }

            $booking_amount = $company['booking_amount'];
            $share_percentage = $company['share_percentage'];

            $fly_commission_before_refund = !empty($company['fly_commission']) ? ($share_percentage / 100 * ($booking_amount)) : (17 / 100 * ($booking_amount));
            $company_commission_before_refund = !empty($company['company_commission']) ? ($booking_amount - ($share_percentage / 100 * ($booking_amount))) : ($booking_amount - (17 / 100 * ($booking_amount)));
            $company_commission_after_refund = $company_commission_before_refund;

            if ($adjust != $company['booking_amount'] && $adjust > 0) {
                //$booking_amount = $booking_amount - $adjust;
                $company_commission_after_refund = $company_commission_before_refund - $adjust;
            }
            if ($adjust == $company['booking_amount']) {
                $company_commission_after_refund = $company_commission_before_refund - $adjust;
            }

            $company_commission = $company_commission_after_refund;
            $fly_commission = $fly_commission_before_refund;

            // $explode  = explode("FP",$company['company_code']);
            // $cname = $explode[1];
            // $cname = $db->get_row("SELECT name from " . $db->prefix . "companies where id = '".$cname."'");
            // $cname = isset($cname['name']) ? $cname['name'] : $company['booked_type'];
            $cname = $company['company_name'];

            // $company_commission = !empty($company['company_commission']) ? $company['company_commission'] : ($company['booking_amount'] - (17/100*($company['booking_amount'])));
            // $fly_commission = !empty($company['fly_commission']) ? $company['fly_commission'] : (17/100*($company['booking_amount']));
            // $company_commission = !empty($company['company_commission']) ? ($booking_amount - ($share_percentage/100*($booking_amount))) : ($booking_amount - (17/100*($booking_amount)));
            // $fly_commission = !empty($company['fly_commission']) ? ($share_percentage/100*($booking_amount)) : (17/100*($booking_amount));

            $booking_amount = $company['booking_amount'];
            $totals = $company['total_amount'];

            // if($adjust == $company['booking_amount'] || $cancel == $company['booking_amount']){
            $cancel_remaining_amount = 0;
            if ($cancel > 0) {
                $company_commission = 0;
                $fly_commission = 0;
                $cancel_remaining_amount = $booking_amount - $cancel;
            }

            $output = $i . "\t";
            $output .= $company['referenceNo'] . "\t";
            $output .= $cname . "\t";
           // $output .= $company['airport_name'] . "\t";
            $output .= $company['Surname'] . "\t";
            $output .= $company['booking_status'] . "\t";
            $output .= $company['payment_method'] . "\t";
            $output .= date("d/m/Y", strtotime($company['createdate'])) . "\t";
            $output .= date("d/m/Y", strtotime($company['start_date'])) . "\t";
            $output .= date("d/m/Y", strtotime($company['end_date'])) . "\t";
            $output .= $company['no_of_days'] . "\t";
            $output .= $cancel . "\t";
           // $output .= $adjust . "\t";
            $output .= $company['booking_amount'] . "\t";
            $output .= $company['make'] . "\t";
            $output .= $company['model'] . "\t";
            $output .= $company['color'] . "\t";
            $output .= $company['registration'] . "\t";
            //\t Vehicle make \t Model \t Color \t Registration

            //$output .= (float)number_format($company_commission, 3) . "\t";
           // $output .= (float)number_format($fly_commission, 3) . "\t";
           // $output .= $cancel_remaining_amount . "\t";
           // $output .= $company['payment_medium'] . "\t";
           // $output .= $company['palenty_to'] . "\t";
           // $output .= $company['palenty_amount'] . "\t";
            //$output .= ($company['palenty_amount'] + $adjust) . "\t";


            $i++;
            if ($company['palenty_to'] == "Company") {
                $total_planty_to_company += $company['palenty_amount'];
            }
            if ($company['palenty_to'] == "Parkingzone") {
                $total_planty_to_fly += $company['palenty_amount'];
            }

            //$total += $company['total_amount'];
            $total += $totals;
            //$total += $company['total_amount'];
            $lprice += $company['booking_amount'];
            $aprice += $company_commission;
            $commission_price += $fly_commission;
            //$extra_amount += $company['extra_amount'];
            //$discount += $company['discount_amount'];

            if($company["booking_status"] == 'Cancelled'){
                $can_count++;
            }
            if($company["booking_status"] == 'Refund'){
                $ref_count++;
            }

            $allrefund += $adjust;
            $cancelled += $cancel;
            //$extra_amount += $company['extra_amount'];
            //$discount += $company['discount_amount'];

            print(trim($output)) . "\t\n";
        }

        $totalamount = ($total * 1) + ($discount * 1);
        if ($allrefund > 0 || $cancelled > 0) {
            $totalamount = $totalamount - $allrefund - $cancelled;
            $total = $total - $allrefund - $cancelled;
            //$lprice = $lprice - $allrefund ;

        }

        $return_book = $lprice - $allrefund - $cancelled;
        $vat = 20 / 100 * $aprice;
        $cprice = $aprice - $vat;
        $adjusts = isset($_GET['adjust']) ? $_GET['adjust'] : 0;
        $net_amount = $aprice + $adjusts;

        $totalcommission = ($commission_price * 1) - ($discount * 1);

        echo " \n \n \n \t Total Booking amount Paid by customer \t" . $lprice . " \t \t \t \t \t \t \t \t \t \t \t \t \t ";
        echo " \n \t Net Amount Paid by customer \t" . $return_book . " \t \t \t \t \t \t \t \t \t \t \t \t \t ";


        echo " \n \t Total Booking Cancel Amount \t" . $cancelled . " \t \t \t \t \t \t \t \t \t \t \t \t \t ";
        echo " \n \t Total Booking Refund Amount \t" . $allrefund . " \t \t \t \t \t \t \t \t \t \t \t \t \t ";
        echo " \n \t Total Company planty Amount \t" . $total_planty_to_company . " \t \t \t \t \t \t \t \t \t \t \t \t \t \t  ";
        echo " \n \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t ";
        echo "\n\n \t Total Bookings \t  ".count($companies)."\t  ";
        echo "\n \t Total No of Refund \t  ".$ref_count."\t  ";
        echo "\n \tTotal No of Cancel \t  ".$can_count."\t  ";
        echo "\n \tTotal No of Booked \t  ".(count($companies) - $can_count - $ref_count)."\t  ";

        echo "\n";
        echo "\t";





         //print(trim($output))."\t\n";
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $role_nam = users_roles::get_user_role(Auth::user()->id)->name;

        set_time_limit(0);
        $bookings = new airports_bookings();
        $bookings_count = new airports_bookings();
        $data = $request->all();
        $admins = User::all();
        $airports = airport::all();
        $companies_dlist = Company::all();


        $show = 0;

        if ($request->has("search")) {
            $name = $request->input("search");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("referenceNo", $name);
                $bookings_count = $bookings_count->where("referenceNo", $name);
            }
        }

        if ($request->has("filter") && $request->has("start_date") && $request->has("end_date") ) {
            $name = $request->input("filter");

            if($name !="" && $name !="all" ) {
                $start_date = date("Y-m-d",strtotime($request->input("start_date")));
                $end_date = date("Y-m-d",strtotime($request->input("end_date")));


                $bookings = $bookings->whereBetween(DB::raw('DATE_FORMAT('.$name.', "%Y-%m-%d")'), [$start_date,$end_date]);
                $bookings_count = $bookings_count->whereBetween(DB::raw('DATE_FORMAT('.$name.', "%Y-%m-%d")'), [$start_date,$end_date]);
            }
        }
//dd($bookings_count);
        if ($request->has("booking_source")) {
            $name = $request->input("booking_source");

            if($name !="" && $name !="all" ) {
              //  dd($name);
                $bookings = $bookings->where("traffic_src", $name);
                $bookings_count = $bookings_count->where("traffic_src", $name);
            }
        }
        if ($request->has("no_of_days") ) {
            $name = $request->input("no_of_days");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("no_of_days", $name);
                $bookings_count = $bookings_count->where("no_of_days", $name);
            }
        }

        if ($request->has("airport") ) {
            $name = $request->input("airport");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("airportID", $name);
                $bookings_count = $bookings_count->where("airportID", $name);
            }
        }
        if ($request->has("companies") ) {
            $name = $request->input("companies");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("companyId", $name);
                $bookings_count = $bookings_count->where("companyId", $name);
            }
        }

        if ($request->has("agentID") ) {
            $name = $request->input("agentID");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("agentID", $name);
                $bookings_count = $bookings_count->where("agentID", $name);
            }
        }

        if ($request->has("payment")) {
            $name = $request->input("payment");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("payment_method", $name);
                $bookings_count = $bookings_count->where("payment_method", $name);
            }
        }
        if ($request->has("my_status")) {
            $name = $request->input("my_status");
            if($name !="" && $name !="all" ) {
                $bookings = $bookings->where("booking_status", $name);
                $bookings_count = $bookings_count->where("booking_status", $name);
            }
        }


        $bookings = $bookings->orderBy('id', 'DESC');
        $bookings_count = $bookings_count->orderBy('id', 'DESC')->get();


        $bookings = $bookings->paginate(20);



if( $role_nam =="Operations" || $role_nam =="Sales"){

     return view("admin.booking.booking_list_operations", ["companies_dlist" => $companies_dlist, "airports" => $airports, "admins" => $admins, "show" => $show, "bookings" => $bookings, "bookings_count" => $bookings_count ,"role_name"=>$role_nam]);
}
    else {
        return view("admin.booking.booking_list", ["companies_dlist" => $companies_dlist, "airports" => $airports, "admins" => $admins, "show" => $show, "bookings" => $bookings, "bookings_count" => $bookings_count,"role_name"=>$role_nam]);
    }
        //   return view("admin.booking.booking_list", ["bookings" => $bookings]);


    }


    public function incomplete_Booking(Request $request)
    {
        //


        set_time_limit(0);
        $bookings = new airports_bookings();
        $data = $request->all();
        $admins = User::all();
        $airports = airport::all();
        $companies_dlist = Company::all();


        $show = 0;

        if ($request->has("search")) {
            $name = $request->input("search");
            $bookings = $bookings->where("referenceNo", $name);
        }
        if ($request->has("airport")) {
            $name = $request->input("airport");
            $bookings = $bookings->where("airportID", $name);
        }
        if ($request->has("companies")) {
            $name = $request->input("companies");
            $bookings = $bookings->where("companyId", $name);
        }
        if ($request->has("payment")) {
            $name = $request->input("payment");
            $bookings = $bookings->where("payment_method", $name);
        }
        if ($request->has("my_status")) {
            $name = $request->input("my_status");
            $bookings = $bookings->where("booking_status", $name);
        }


        // $bookings = airports_bookings::where("booking_status", "Abandon");
        $bookings = $bookings->where("booking_status", "Abandon");
        $bookings = $bookings->orderBy('id', 'DESC');
        $bookings = $bookings->paginate(20);
        // return view("admin.booking.incomplete_list", ["bookings" => $bookings]);
        return view("admin.booking.incomplete_list", ["companies_dlist" => $companies_dlist, "airports" => $airports, "admins" => $admins, "show" => $show, "bookings" => $bookings]);
    }

    public function dsp()
    {
        //

        return view("admin.dsp.dsp");
    }

    public function dspview()
    {
        //

        return view("admin.dsp.dspview");
    }

    public function airport_commission_report()
    {
        //
        $bookings = airports_bookings::where("booking_status", "Abandon")->paginate(20);
        return view("admin.reports.airport_commission_report", ["bookings" => $bookings]);
    }
//       public function invoice_commission_report()
//    {
//        //
//        $bookings = airports_bookings::where("booking_status", "Abandon")->paginate(20);
//        return view("admin.invoices.invoice_commission_report", ["bookings" => $bookings]);
//    }
    public function company_report()
    {
        //
        $bookings = airports_bookings::where("booking_status", "Abandon")->paginate(20);
        return view("admin.reports.company_report", ["bookings" => $bookings]);
    }

    public function bookinghistroy(Request $request)
    {
        $bookings = new booking_transaction();
        $bookings = $bookings->select("booking_transaction.*");
        $bookings = $bookings->leftjoin('booking_transaction as t', 't.orderID', '=', 'booking_transaction.orderID');
        if ($request->has("name")) {
            $name = $request->input("name");
            $bookings = $bookings->where("booking_transaction.referenceNo", $name);
        }

        //  $bookings = airports_bookings::where("booking_status", "Abandon")->paginate(20);

        $bookings = $bookings->where("booking_transaction.booking_status", "Abandon");
        //$bookings= $bookings->where("booking_transaction.id", "t.id");
        //$bookings= $bookings->where("booking_transaction.id","<", "t.id");


        $bookings = $bookings->orderBy('t.id', 'DESC');

        $bookings = $bookings->paginate(20);

        return view("admin.booking.bookinghistroy_list", ["bookings" => $bookings]);
    }

    public function sendEmailBooking(Request $request)
    {
        $id = $request->input("id");
        $cid = $request->input("cid");
        $type = $request->input("type");

        $row = airports_bookings::getSingleRowById($id);

        $template_data = [];
        $template_data["username"] = $row->first_name . " " . $row->last_name;
        $template_data["email"] = $row->email;
        $template_data["telephone"] = $row->phone_number;
        $template_data["carpark"] = "Car Park";
        //$template_data["c_parent"] = "";
        if ($row->company) {
            $template_data["c_parent"] = $row->company->name;
        }
        $template_data["ptype"] = $row->booked_type;
        if ($row->airport) {
            $template_data["airport"] = $row->airport->name;
        }
        $template_data["terminal"] = $row->deprTerminal;
        $template_data["rterminal"] = $row->returnTerminal;
        $template_data["days"] = $row->no_of_days;
        $template_data["start_date"] = $row->departDate;
        $template_data["end_date"] = $row->returnDate;
        $template_data["booktime"] = $row->created_at;
        $template_data["r_flight_no"] = $row->returnFlight;
        $template_data["reg"] = $row->registration;
        $template_data["model"] = $row->model;
        $template_data["make"] = $row->make;
        $template_data["color"] = $row->color;
        $template_data["payment_gatway"] = $row->payment_method;
        $template_data["payment_status"] = "success";
        $template_data["price"] = $row->total_amount;
        $template_data["addtionalprice"] = 0;
        $template_data["ref"] = $row->referenceNo;
        $email_send = new EmailController();
        if ($type == "client" || $type == "all") {

            //dd($row->email);
            $email_send->sendEmail("Update Booking", $row->email, $template_data);
        }
        if ($type == "company" || $type == "all") {
            if ($row->company) {
                $email_send = new EmailController();
                $email_send->sendEmail("Add Booking Company", $row->company->company_email, $template_data);
            }
        }

        return "<h2>Email send successfully</h2>";
    }

    function priceFormat($price, $symbol = true)
    {
        $formated_price = '';
        if ($symbol) {
            $formated_price .= '&pound;';
        }
        $formated_price .= number_format(((float)$price * 1), 2);
        return $formated_price;
    }

    public function getQuote(Request $request)
    {


        $messages = [
            'required.dropoffdate' => 'Dropoff Date field is required.',
            'required.pickup_date' => 'Pickup Date field is required.',
            'required.dropoftime' => 'Dropoff Time field is required.',
            'required.pickup_time' => 'Pickup time field is required.',
            'required.airport_id' => 'Airport field is required.'
        ];
        $validatedData = Validator::make(Input::all(), [
            'dropoffdate' => 'required|string|max:255',
            'pickup_date' => 'required|string',
            'dropoftime' => 'required|string',
            'airport_id' => 'required|string',
            'pickup_time' => 'required|string'

        ], $messages);

        if ($validatedData->fails()) {

            //pass validator errors as errors object for ajax response

            return response()->json(["success" => 0, 'errors' => $validatedData->errors()]);
        } else {


            $airport_id = $request->input('airport_id');

            $dropdate = $request->input('dropoffdate');
            $pickdate = $request->input('pickup_date');
            $dropoftime = $request->input('dropoftime');
            $pickuptime = $request->input('pickup_time');
            $no_of_days = $request->input('no_of_days') + 1;

            $promo = $request->input('promo');


            $html = '';
            $i = 1;
            $j = 1;
            $inactive = 0;
            $inactiv = 0;

            $selected_date = strtotime($dropdate);
            $year = date('Y', $selected_date);
            $month = date('n', $selected_date);
            $day = date('j', $selected_date);


            $dropofdate = date('Y-m-d', strtotime($dropdate));
            $pickupdate = date('Y-m-d', strtotime($pickdate));
            $dStart = new DateTime($dropofdate);
            $dEnd = new DateTime($pickupdate);
            $dDiff = $dStart->diff($dEnd);
            $dDiff->format('%R');
            $no_of_days = $dDiff->days;
            $totals_days = $no_of_days + 1;

            if ($no_of_days > 30) {
                $total_days = '30';
            } else {
                $total_days = $no_of_days;
            }

            // Calculate Days Difference From Now
            $dropdate1 = strtotime($dropdate);
            $c_time = date("Y-m-d");
            $dropdate1 = date("Y-m-d", $dropdate1);
            $datetime1 = new DateTime($c_time);
            $datetime2 = new DateTime($dropdate1);
            $interval = $datetime1->diff($datetime2);
            $diff_date = $interval->format('%R%a');
            $diff_date = substr($diff_date, 1);
            ////////********** END **********///////


            $query = "SELECT a.name as airport_name,a.removed as rmd, fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview,IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace,   fapp.id, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_" . $total_days . " >0, fapb.day_" . $total_days . "+fapp.extra, 0.00) AS price FROM companies as fc
                left join companies_set_price_plans as fapp on fc.id = fapp.cid
                left join airports as a on fc.airport_id = a.id
                left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_" . $total_days . "'
                left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name
                WHERE is_active = 'Yes' and fc.removed != 'Yes'  and airport_id = '" . $airport_id . "' and fapp.cmp_month = '" . $month . "'  and fapp.cmp_year = '" . $year . "' 
                ";
//echo $query; die();

            $companies = DB::select(DB::raw($query));

            foreach ($companies as $company) {


                $total_amount = $company->price + $this->_setting["booking_fee"];

                ?>

                <div class="companies-listing">
                    <span class="companies-list"><?php echo $company->name ?><?php echo $company->airport_name; ?> </span>
                    <span class="companies-list-dd">(<?php echo $company->parking_type ?> )</span>
                    <table class="table clisting-table">
                        <tbody>
                        <tr>
                            <th>Booking Price</th>
                            <td>£<?php echo $company->price ?></td>
                            <th>Booking Fee</th>
                            <td>£<?php echo $this->_setting["booking_fee"]; ?></td>

                        </tr>
                        <tr>
                            <th>Add Extra</th>
                            <td>£0.00</td>
                            <th><b>Total Amount</b></th>
                            <td class="price-text">£<?php echo $total_amount; ?></td>
                            <th></th>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <form id="cform<?php echo $company->companyID ?>" method="post">
                        <input type="hidden" name="company_id" value="<?php echo $company->companyID ?>">
                        <input type="hidden" name="company_name" value="<?php echo $company->name ?>">
                        <input type="hidden" name="parking_type" value="<?php echo $company->parking_type ?>">
                        <input type="hidden" name="booking_price" value="<?php echo $company->price ?>">
                        <input type="hidden" name="discount_price" value="0.00">
                        <input type="hidden" name="cancel_price"
                               value="<?php echo $this->_setting["cancellation_fee"] ?>">
                        <input type="hidden" name="booking_fee" value="<?php echo $this->_setting["booking_fee"]; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $total_amount; ?>">
                        <input type="hidden" name="discounted_amount" value="0.00">

                        <input type="hidden" name="airport_name" value="<?php echo $company->airport_name; ?>">
                        <input type="hidden" name="dropoffdate" value="<?php echo $request->input("dropoffdate"); ?>">
                        <input type="hidden" name="pickup_date" value="<?php echo $request->input("pickup_date"); ?>">
                        <input type="hidden" name="pickup_time" value="<?php echo $request->input("pickup_time"); ?>">
                        <input type="hidden" name="dropoftime" value="<?php echo $request->input("dropoftime"); ?>">

                        <input type="hidden" name="airport_id" value="<?php echo $request->input("airport_id"); ?>">
                        <input type="hidden" name="total_days" value="<?php echo $total_days; ?>">


                        <input type="hidden" name="extra_amount" value="0.00">

                        <input type="button" onclick="selectCompany(<?php echo $company->companyID ?>)"
                               class="btn btn-primary"
                               value="Select">
                    </form>
                </div>

                <?php
            }


            //return response()->json(["success" => 1, 'data' => $companies]);
            //$this->respondCreated('Lesson created successfully');
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $edit = 0;
        $airports = airport::getAll();
        return view("admin.booking.add_booking", ["airports" => $airports, "type" => "add", "settings" => $this->_setting, "edit" => $edit]);

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

        //dd($request);

        $airport_id = $request->input("airport_id");

        $dropdate = $request->input("dep_date");
        $droptime = $request->input("departure_time");
        $pickdate = $request->input("return_date");
        $picktime = $request->input("return_time");


        $dep_date = date('Y-m-d H:i:s', strtotime($dropdate . " " . $droptime));
        $return_date = date('Y-m-d H:i:s', strtotime($pickdate . " " . $picktime));


        $promo = $request->input("promo");
        $first_name = $request->input("first_name");
        $title = $request->input("title");
        $last_name = $request->input("last_name");
        $email = $request->input("email");
        $contact = $request->input("contact");

        $address = $request->input("address");
        $address2 = $request->input("address2");
        $post_code = $request->input("post_code");
        $town = $request->input("town");
        $departure_terminal = $request->input("departure_terminal");
        $return_terminal = $request->input("return_terminal");

        $veh_make = $request->input("veh_make");
        $veh_model = $request->input("veh_model");
        $veh_colour = $request->input("veh_colour");
        $veh_registration = $request->input("veh_registration");
        $transaction_id = $request->input("transaction_id");

        $payment_method = $request->input("payment_method");

        $company_id = $request->input("company_id");
        $parking_type = $request->input("parking_type");
        $discount_amount = $request->input("discount_amount");
        $p_booking_amount = $request->input("p_booking_amount");
        $payment_method = $request->input("payment_method");

        $postalFEE = $request->input("postalFEE");
        $bookingFEE = $request->input("bookingFEE");
        $add_extra = $request->input("add_extra");
        $totalAMOUNT = $request->input("totalAMOUNT");
        $h_totalAMOUNT = $request->input("h_totalAMOUNT");

        $no_of_days = $request->input("no_of_days");
        $smsFEE = $request->input("smsFEE");
        $cancelFEE = $request->input("cancelFEE");
        $passenger = $request->input("passenger");
        $return_flight_no = $request->input("return_flight_no");
        $dept_flight_no = $request->input("dept_flight_no");

        //creating customer
        $pass = $this->randomPassword();
        $data = array();
        $data["title"] = $title;
        $data["first_name"] = $first_name;
        $data["last_name"] = $last_name;
        $data["phone_number"] = $contact;
        $data["password"] = md5($pass);
        $data["address"] = $address;
        $data["address2"] = $address2;
        $data["town"] = $town;
        $data["added_on"] = date("Y-m-d H:i:s");
        $data["update_on"] = date("Y-m-d H:i:s");
        $data["email"] = $email;

        $customer_exist = customers::where('email', $request->input('email'))->first();
        if ($customer_exist) {
            $customerData = customers::where('email', $email)
                ->update($data);
            $customer_id = $customer_exist->id;

        } else {

            $customerData = customers::updateOrCreate($data);
            $customer_id = $customerData->id;

        }
//creating customer end
        $ip = request()->ip();
        $data = [];
        $data["airportID"] = $airport_id;
        $data["customerId"] = $customer_id;
        $data["companyId"] = $company_id;
        $data["title"] = $title;
        $data["first_name"] = $first_name;
        $data["last_name"] = $last_name;
        $data["email"] = $email;
        $data["phone_number"] = $contact;
        $data["fulladdress"] = $address;
        $data["address"] = $address;
        $data["address2"] = $address2;
        $data["town"] = $town;
        $data["postal_code"] = $post_code;
        $data["passenger"] = $passenger;
        $data["departDate"] = $dep_date;
        $data["deprTerminal"] = $departure_terminal;
        $data["deptFlight"] = $dept_flight_no;
        $data["returnDate"] = $return_date;
        $data["returnFlight"] = $return_flight_no;
        $data["returnTerminal"] = $return_terminal;
        $data["no_of_days"] = $no_of_days;
        $data["discount_code"] = $promo;
        $data["discount_amount"] = $discount_amount;
        $data["booking_amount"] = $p_booking_amount;
        $data["booking_extra"] = $add_extra;
        $data["smsfee"] = $smsFEE;

        $data["booking_fee"] = $bookingFEE;
        $data["cancelfee"] = $cancelFEE;
        $data["total_amount"] = $totalAMOUNT;
        //$data["leavy_fee"] = $l_fee;
        $data["booked_type"] = $parking_type;

        $data["make"] = $veh_make;
        $data["model"] = $veh_model;
        $data["color"] = $veh_colour;
        $data["registration"] = $veh_registration;
        $data["payment_method"] = $payment_method;
        $data["user_ip"] = $ip;
        $data["booking_status"] = "completed";
        $data["payment_status"] = "success";

        // dd($data);

        //if ($referenceNo == '') {
        //$booking = airports_bookings::create($data)->toSql();
        $booking_id = DB::table("airports_bookings")->insertGetId($data);

//                $booking_id = $booking->id;
//        } else {
//            $booking = airports_bookings::where('referenceNo', $referenceNo)->first();
//            if ($booking) {
//                airports_bookings::where("referenceNo", $referenceNo)->update($data);
//                $booking_id = $booking->id;
//            } else {
//                $booking_id = 0;
//            }
//        }
        $bookingref = 'AP-';
        $bookingref .= date("y") . date("m") . date("d");
        //$bookingref = $bookingref.substr($_bookID, -3);

        $bookingref = $bookingref . $booking_id;
        $data = [];
        $data["referenceNo"] = $bookingref;
        airports_bookings::where("id", $booking_id)->update($data);


        return response(["success" => "1"]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showdetail(Request $request)
    {
        //
        $discount_amount = 0;

        $id = $request->input("id");
        $row = airports_bookings::getSingleRowById($id);

        if ($row->booking_amount > $row->discount_amount) {
            $discount_amount = ((float)$row->total_amount + (float)$row->discount_amount);
        }
        $company_name = "";
        if ($row->company) {
            $company_name = $row->company->name;
        }
        $airport_name = "";
        if ($row->airport) {
            $airport_name = $row->airport->name;
        }
        $rterminal = "";
        if ($row->rterminal) {
            $rterminal = $row->rterminal->name;
        }
        $dterminal = "";
        if ($row->dterminal) {
            $dterminal = $row->dterminal->name;
        }

        $address = $row->address;
        if ($row->address == "") {
            $address = $row->fulladdress;
        }

        $html = "<div><h2>Booking Detail</h2></div><div style=\"overflow-y: scroll; margin-top: 30px\"> 
    <div class=\"row\" style=\"margin-bottom: 10px;\">
        <div class=\"col-md-6\">
        <table class=\"table table-bordered responsive\">
        <tr>
        <td>Booking Reference:</td>
        <td>" . $row->referenceNo . "</td>
        </tr>
        
        <tr>
        <td>Departure Date:</td>
        <td>" . date("Y-m-d", strtotime($row->departDate)) . "</td>
        </tr>
        
        
        <tr>
        <td>Departure Time:</td>
        <td>" . date("H:i:s", strtotime($row->departDate)) . "</td>
        </tr>
        
        
        <tr>
        <td>Return Date:</td>
        <td>" . date("Y-m-d", strtotime($row->returnDate)) . "</td>
        </tr>
        
        <tr>
        <td>Return Time:</td>
        <td>" . date("H:i:s", strtotime($row->returnDate)) . "</td>
        </tr>
        
       
        
        <tr>
        <td>Return Flight:</td>
        <td>" . $row->returnFlight . "</td>
        </tr>
        
        
        <tr>
        <td>Departure Terminal:</td>
        <td>" . $dterminal . "</td>
        </tr>
        
        
        <tr>
        <td>Arrival Terminal:</td>
        <td>" . $rterminal . "</td>
        </tr>
        
        
        <tr>
        <td>Airport:</td>
        <td>" . $airport_name . "</td>
        </tr>
        
        
        <tr>
        <td>Company Name:</td>
        <td>" . $company_name . "</td>
        </tr>
        
        
        
        
        
        </table>
            
        </div>
        <div class=\"col-md-6\">
            <table class=\"table table-bordered responsive\">
        <tr>
        <td>Name:</td>
        <td>" . $row->first_name . " " . $row->last_name . "</td>
        </tr>
        
        <tr>
        <td>Contact Number:</td>
        <td>" . $row->phone_number . "</td>
        </tr>
        
        
        <tr>
        <td>Email Address:</td>
        <td>" . $row->email . "</td>
        </tr>
        
        
        <tr>
        <td>Address:</td>
        <td>" . $address . "</td>
        </tr>
        
        <tr>
        <td>Postal:</td>
        <td>" . $row->postal_code . "</td>
        </tr>
        
        <tr>
        <td>Make:</td>
        <td>" . $row->make . "</td>
        </tr>
        
        <tr>
        <td>Model:</td>
        <td>" . $row->model . "</td>
        </tr>
        
        
        <tr>
        <td>Colour:</td>
        <td>" . $row->color . "</td>
        </tr>
        
        
        <tr>
        <td>Registration No:</td>
        <td>" . $row->registration . "</td>
        </tr>
        
        
        
        
        
        
        
        </table>
        </div>
    </div><table class=\"table table-bordered responsive\">
			<thead>
			<tr>
				<th>Booking Amount</th>
				<th>Extra Amount</th>
				<th>Sms Fee</th>
				<th>Booking Fee</th>
				<th>Cancel Fee</th>
				<th>Levy Fee</th>
				<th>T Amount without Discount</th>
				<th>Discount Code</th>
				<th>Discount Amount</th>
				<th>Net Amount to Pay</th>
			</tr>
			</thead>
			<tbody><tr>
				<td><stron class=\"badge badge-success badge-roundless\">" . $this->priceFormat($row->booking_amount) . "</stron></td>
				<td>" . $this->priceFormat($row->extra_amount) . "</td>
				<td>" . $this->priceFormat($row->smsfee) . "</td>
				<td>" . $this->priceFormat($row->booking_fee) . "</td>
				<td>" . $this->priceFormat($row->cancelfee) . "</td>
				
				<td>" . $this->priceFormat($row->leavy_fee) . "</td>
				<td>" . $this->priceFormat($discount_amount) . "</td>
				<td>" . $row->discount_code . "</td>
				<td>" . $this->priceFormat($row->discount_amount) . "</td>
				<td><stron class=\"badge badge-success badge-roundless\">" . $this->priceFormat($row->total_amount) . "</stron></td>
			</tr>
			</tbody><tbody>
			</tbody></table>
			<table class=\"table table-bordered responsive\">
			<thead>
			<tr>
			    <th>Payer ID</th>
				<th>Token</th>
				<th>Payment Method</th>
				<th>Payment Status</th>
				<th>Booking Status</th>
			</tr>
			</thead>
			<tbody><tr>
			    <td>" . $row->PayerID . "</td>
				<td></td>
				<td>" . $row->payment_method . "</td>
				<td>" . $row->payment_status . "</td>
				<td>" . $row->booking_status . "</td>
			</tr>
			</tbody><tbody>
			</tbody></table></div>";
        return $html;

    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    public function cancelForm(Request $request)
    {

        //
        $id = $request->input("id");
        $row = airports_bookings::getSingleRowById($id);

        $discount_amount = 0;

        if ($row->booking_amount > $row->discount_amount) {
            $discount_amount = ((float)$row->total_amount + (float)$row->discount_amount);
        }
//        $company_name = "";
//        if ($row->company) {
//            $company_name = $row->company->name;
//        }
//        $airport_name = "";
//        if ($row->airport) {
//            $airport_name = $row->airport->name;
//        }

        $html = "<div><h2>Booking Detail</h2></div><div style=\"overflow-y: scroll; text-align: left; margin-top: 30px\"> 
    
            <table class=\"table table-bordered responsive\">
			<thead>
			<tr>
				<th>Booking Amount</th>
				<th>Extra Amount</th>
				<th>Sms Fee</th>
				<th>Booking Fee</th>
				<th>Cancel Fee</th>
				<th>Levy Fee</th>
				<th>T Amount without Discount</th>
				<th>Discount Code</th>
				<th>Discount Amount</th>
				<th>Net Amount to Pay</th>
			</tr>
			</thead>
			<tbody><tr>
				<td><stron class=\"badge badge-success badge-roundless\">" . $this->priceFormat($row->booking_amount) . "</stron></td>
				<td>" . $this->priceFormat($row->extra_amount) . "</td>
				<td>" . $this->priceFormat($row->smsfee) . "</td>
				<td>" . $this->priceFormat($row->booking_fee) . "</td>
				<td>" . $this->priceFormat($row->cancelfee) . "</td>
				
				<td>" . $row->leavy_fee . "</td>
				<td>" . $this->priceFormat($discount_amount) . "</td>
				<td>" . $row->discount_code . "</td>
				<td>" . $this->priceFormat($row->discount_amount) . "</td>
				<td><stron class=\"badge badge-success badge-roundless\">" . $row->total_amount . "</stron></td>
			</tr>
			</tbody><tbody>
			</tbody></table>
			<table class=\"table table-bordered responsive\">
			<thead>
			<tr>
			    <th>Payer ID</th>
				<th>Token</th>
				<th>Payment Method</th>
				<th>Payment Status</th>
				<th>Booking Status</th>
			</tr>
			</thead>
			<tbody><tr>
			    <td>" . $row->PayerID . "</td>
				<td></td>
				<td>" . $row->payment_method . "</td>
				<td>" . $row->payment_status . "</td>
				<td>" . $row->booking_status . "</td>
			</tr>
			</tbody><tbody>
			</tbody></table>
			
			<p class=\"alert alert-warning\"><b>This product is cancelable product but user did not pay cancelation fee..!!!</b></p>
			<div id='response'></div>
			<h2>Cancel</h2>
	        <form class=\"form-horizontal\" action=\"\" method=\"post\" id=\"form1\">
		    <table class=\"table table-bordered table-striped responsive\">
			<thead>
			<tr>
				<th></th>
				<th>Enter the Booking amount to be Cancelled</th>
				<th></th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><input class=\"radio-resend\" type=\"checkbox\" value=\"client\" name=\"client\"> Send Email to Client <br>
				<input class=\"radio-resend\" type=\"checkbox\" value=\"company\" name=\"company\"> Send Email to Company <br>
				<input class=\"radio-resend\" type=\"checkbox\" value=\"admin\" name=\"admin\"> Send Email to Admin</td>
				<td><input type=\"text\" value=\"$row->total_amount\" name=\"amount\" class=\"form-control\" placeholder=\"Enter booking Amount to be Cancelled\"><br>Suggested Amount $row->total_amount</td>
				
				<td><input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Cheque\"> Refund Via Cheque<br>
				<input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Charge back\"> Refund Via Charge back<br>
				<input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br>
				<input type=\"checkbox\" checked=\"\" name=\"booking_payment_medium\" value=\"Payment Gateway\"> Refund Via Payment Gateway
				</td>
				<td><input type=\"submit\" id=\"button1\" name=\"refund\" class=\"btn btn-info\" value=\"Save\"></td>
			</tr>
			<tr>
				<td colspan=\"4\">
					<table style=\"width: 680px;\" class=\"cancelchild1\">
						
					</table>
				</td>
			
			
			</tr>
			
			<tr id=\"cancelparent\">
				
				<td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"><br>
				<input type=\"checkbox\" name=\"palenty_to[]\" value=\"Company\"> To Company<br>
				<input type=\"checkbox\" checked=\"\" name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone
				</td>
				<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br>
				<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br>
				<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br>
				<input type=\"checkbox\" checked=\"\" name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway
				</td>				
				<td><input type=\"button\" id=\"cancelbutton3\" class=\"btn btn-info\" value=\"Add more\"></td>	
			</tr>
			</tbody>
		</table>
		<textarea class=\"col-md-12\" placeholder=\"Enter Reason Here....\" name=\"reason\" id=\"reason1\">Customer Emailed</textarea>
		<input type=\"hidden\" name=\"id\" value=\"$row->id\">
		<input type=\"hidden\" name=\"mode\" value=\"cancel\">
		<input type=\"hidden\" name=\"t_amount\" value=\"$row->total_amount\">
	</form>
			<script type=\"text/javascript\">




$('#button3').click(function () {
	
    var div = $('.child1').length;
   
    $('.child1').append('<tr class=\"childn\"><td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"/><br/>'+
				'<input type=\"checkbox\" checked name=\"palenty_to[]\" value=\"Company\"> To Company<br/>'+
				'<input type=\"checkbox\"  name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone'+
				'</td>'+
				'<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br/>'+
				
				'<input type=\"checkbox\" checked name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway'+
				'</td>'+				
				'<td><a class=\"btn btn-red\" id=\"Remove_product\">Remove</a></td></tr>');
});
$(document).on(\"click\", \"#Remove_product\", function() {
	
    $(this).closest('.childn').remove();
});
$('#cancelbutton3').click(function () {
	
    var div = $('.cancelchild1').length;
   
    $('.cancelchild1').append('<tr class=\"cancelchildn\"><td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"/><br/>'+
				'<input type=\"checkbox\" checked name=\"palenty_to[]\" value=\"Company\"> To Company<br/>'+
				'<input type=\"checkbox\"  name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone'+
				'</td>'+
				'<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br/>'+
				'<input type=\"checkbox\" checked name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway'+
				'</td>'+				
				'<td><a class=\"btn btn-red\" id=\"cancelRemove_product\">Remove</a></td></tr>');
});
$(document).on(\"click\", \"#cancelRemove_product\", function() {
	
    $(this).closest('.cancelchildn').remove();
});






$('#form1').on('submit', function(event) {
	if($('#form1 input[name=\"amount\"]').val()==''){
		alert('Amount is required.....!!');
		return false;
	}
    else if($('#form1 textarea[name=\"reason\"]').val()==''){
		alert('Reason is required.....!!');
		return false;
	}else{
		  event.preventDefault();
		  $.ajax({
                   url:'" . route('cancelFormAction') . "',
                    type:'POST',
                    data:$(this).serialize(),
                    
                    success:function(result){
                    $('#response').addClass('alert alert-danger');
                         $(\"#response\").text(result.message); 
                        if(result.success==1){ 
                            $('#response').addClass('alert alert-success');
                             $('.bootbox.modal').modal('hide');
                         }

                    }

            });
	}
       
});
</script>
			</div>";
        return $html;

    }


    public function refundForm(Request $request)
    {
        //
        $id = $request->input("id");
        $row = airports_bookings::getSingleRowById($id);
//        $company_name = "";
//        if ($row->company) {
//            $company_name = $row->company->name;
//        }
//        $airport_name = "";
//        if ($row->airport) {
//            $airport_name = $row->airport->name;
//        }

        $html = "<div><h2>Booking Detail</h2></div><div style=\"overflow-y: scroll; text-align: left; margin-top: 30px\"> 
    
            <table class=\"table table-bordered responsive\">
			<thead>
			<tr>
				<th>Booking Amount</th>
				<th>Extra Amount</th>
				<th>Sms Fee</th>
				<th>Booking Fee</th>
				<th>Cancel Fee</th>
				<th>Levy Fee</th>
				<th>T Amount without Discount</th>
				<th>Discount Code</th>
				<th>Discount Amount</th>
				<th>Net Amount to Pay</th>
			</tr>
			</thead>
			<tbody><tr>
				<td><stron class=\"badge badge-success badge-roundless\">" . $row->total_amount . "</stron></td>
				<td>" . $row->extra_amount . "</td>
				<td>" . $row->smsfee . "</td>
				<td>" . $row->booking_fee . "</td>
				<td>" . $row->cancelfee . "</td>
				
				<td>" . $row->leavy_fee . "</td>
				<td>" . $row->discount_code . "</td>
				<td>" . $row->discount_code . "</td>
				<td>" . $row->discount_amount . "</td>
				<td><stron class=\"badge badge-success badge-roundless\">" . $row->total_amount . "</stron></td>
			</tr>
			</tbody><tbody>
			</tbody></table>
			<table class=\"table table-bordered responsive\">
			<thead>
			<tr>
			    <th>Payer ID</th>
				<th>Token</th>
				<th>Payment Method</th>
				<th>Payment Status</th>
				<th>Booking Status</th>
			</tr>
			</thead>
			<tbody><tr>
			    <td>" . $row->PayerID . "</td>
				<td></td>
				<td>" . $row->payment_method . "</td>
				<td>" . $row->payment_status . "</td>
				<td>" . $row->booking_status . "</td>
			</tr>
			</tbody><tbody>
			</tbody></table>
			
			<p class=\"alert alert-warning\"><b>This product is cancelable product but user did not pay cancelation fee..!!!</b></p>
			<div id='response'></div>
			<h2>Refund</h2>
	        <form class=\"form-horizontal\" action=\"\" method=\"post\" id=\"form1\">
		    <table class=\"table table-bordered table-striped responsive\">
			<thead>
			<tr>
				<th></th>
				<th>Enter Amount to be refunded	</th>
				<th></th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<tr >
				<td><input class=\"radio-resend\" type=\"checkbox\" value=\"client\" name=\"client\"> Send Email to Client <br>
				<input class=\"radio-resend\" type=\"checkbox\" value=\"company\" name=\"company\"> Send Email to Company <br>
				<input class=\"radio-resend\" type=\"checkbox\" value=\"admin\" name=\"admin\"> Send Email to Admin</td>
				<td style=\"display:none;\"><input type=\"text\" value=\"$row->total_amount\" name=\"amount\" class=\"form-control\" placeholder=\"Enter booking Amount to be Cancelled\"><br>Suggested Amount $row->total_amount</td>
				
				<td style=\"display:none;\"><input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Cheque\"> Refund Via Cheque<br>
				<input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Charge back\"> Refund Via Charge back<br>
				<input type=\"checkbox\" name=\"booking_payment_medium\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br>
				<input type=\"checkbox\" checked=\"\" name=\"booking_payment_medium\" value=\"Payment Gateway\"> Refund Via Payment Gateway
				</td>
				<td><input type=\"submit\" id=\"button1\" name=\"refund\" class=\"btn btn-info\" value=\"Save\"></td>
			</tr>
			<tr>
				<td colspan=\"4\">
					<table style=\"width: 680px;\" class=\"cancelchild1\">
						
					</table>
				</td>
			
			
			</tr>
			
			<tr id=\"cancelparent\">
				
				<td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"><br>
				<input type=\"checkbox\" name=\"palenty_to[]\" value=\"Company\"> To Company<br>
				<input type=\"checkbox\" checked=\"\" name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone
				</td>
				<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br>
				<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br>
				<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br>
				<input type=\"checkbox\" checked=\"\" name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway
				</td>				
				<td><input type=\"button\" id=\"cancelbutton3\" class=\"btn btn-info\" value=\"Add more\"></td>	
			</tr>
			</tbody>
		</table>
		<textarea class=\"col-md-12\" placeholder=\"Enter Reason Here....\" name=\"reason\" id=\"reason1\">Customer Emailed</textarea>
		<input type=\"hidden\" name=\"id\" value=\"$row->id\">
		<input type=\"hidden\" name=\"mode\" value=\"cancel\">
		<input type=\"hidden\" name=\"t_amount\" value=\"$row->total_amount\">
	</form>
			<script type=\"text/javascript\">




$('#button3').click(function () {
	
    var div = $('.child1').length;
   
    $('.child1').append('<tr class=\"childn\"><td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"/><br/>'+
				'<input type=\"checkbox\" checked name=\"palenty_to[]\" value=\"Company\"> To Company<br/>'+
				'<input type=\"checkbox\"  name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone'+
				'</td>'+
				'<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br/>'+
				
				'<input type=\"checkbox\" checked name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway'+
				'</td>'+				
				'<td><a class=\"btn btn-red\" id=\"Remove_product\">Remove</a></td></tr>');
});
$(document).on(\"click\", \"#Remove_product\", function() {
	
    $(this).closest('.childn').remove();
});
$('#cancelbutton3').click(function () {
	
    var div = $('.cancelchild1').length;
   
    $('.cancelchild1').append('<tr class=\"cancelchildn\"><td><input type=\"text\" value=\"\" name=\"palenty_amount[]\" class=\"form-control\" placeholder=\"Enter Palenty Amount to be refunded\"/><br/>'+
				'<input type=\"checkbox\" checked name=\"palenty_to[]\" value=\"Company\"> To Company<br/>'+
				'<input type=\"checkbox\"  name=\"palenty_to[]\" value=\"Parkingzone\"> To Parkingzone'+
				'</td>'+
				'<td><input type=\"checkbox\" name=\"payment_medium[]\" value=\"Cheque\"> Refund Via Cheque<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Charge back\"> Refund Via Charge back<br/>'+
				'<input type=\"checkbox\" name=\"payment_medium[]\" value=\"Bank Transfer\"> Refund Via Bank Transfer<br/>'+
				'<input type=\"checkbox\" checked name=\"payment_medium[]\" value=\"Payment Gateway\"> Refund Via Payment Gateway'+
				'</td>'+				
				'<td><a class=\"btn btn-red\" id=\"cancelRemove_product\">Remove</a></td></tr>');
});
$(document).on(\"click\", \"#cancelRemove_product\", function() {
	
    $(this).closest('.cancelchildn').remove();
});






$('#form1').on('submit', function(event) {
	if($('#form1 input[name=\"amount\"]').val()==''){
		alert('Amount is required.....!!');
		return false;
	}
    else if($('#form1 textarea[name=\"reason\"]').val()==''){
		alert('Reason is required.....!!');
		return false;
	}else{
		 
		  event.preventDefault();
		  $.ajax({
                    url:'" . route('cancelFormAction') . "',
                    type:'POST',
                    data:$(this).serialize(),
                    success:function(result){
                       // console.log(result);
                       $('#response').addClass('alert alert-danger');
                        $(\"#response\").text(result.message); 
                        if(result.success==1){ 
                        $('#response').addClass('alert alert-success');
                             $('.bootbox.modal').modal('hide');
                         }
                        

                    }

            });
	}
       
});
</script>
</script>
			</div>";
        return $html;

    }


    public function cancelFormAction(Request $request)
    {

        $id = $request->input("id");

        $already_booking_refunds = 0;
        $refund_trans = booking_transaction::all()->where("orderID", $id);


        foreach ($refund_trans as $refund_tran) {
            $already_booking_refunds += (float)$refund_tran->payable;

        }

        $type = $request->input("mode");
        $reason = $request->input("reason");
        $t_amount = $request->input("t_amount");
        $booking_payment_medium = $request->input("booking_payment_medium");
        $payment_medium = $request->input('payment_medium');
        $palenty_amount = $request->input('palenty_amount');
        $palenty_to = $request->input('palenty_to');
        $amt = !empty($request->input('amount')) ? number_format($request->input('amount'), 2, '.', '') : $request->input('full_r');
        $total_refunded_booking = ($already_booking_refunds + $amt);


        if ($total_refunded_booking > $t_amount) {

            $data["success"] = 0;
            $data["message"] = "Alert !!!! already paid Booking Refunded Amount";

            return response()->json($data);


        } else {

            if ($amt > $t_amount) {
                $data["success"] = 0;
                $data["message"] = "Alert !!!! Booking Refunded Amount Must Be Less Then Customer Paid Booking Amount";
                return response()->json($data);
            } else {
                if ($type == 'cancel') {
                    $email_to = array('client' => $request->input('client'), 'company' => $request->input('company'), 'admin' => $request->input('admin'));
                    $res = $this->refunds($id, $payment_medium, $palenty_amount, $palenty_to, 'cancel', $amt, $reason, "", $email_to, $booking_payment_medium);

                    return response()->json($res);
                }
                if ($type == 'refund') {

                    $email_to = array('client' => $request->input('client'), 'company' => $request->input('company'), 'admin' => $request->input('admin'));

                    $res = $this->refunds($id, $payment_medium, $palenty_amount, $palenty_to, 'refund', $amt, $reason, "", $email_to, $booking_payment_medium);
                    return response()->json($res);
                }
            }
        }

    }


    //Refund
    public function refunds($id, $payment_medium = '', $palenty_amount = '', $palenty_to = '', $mode, $amt, $reason, $type = "", $email_to, $booking_payment_medium = '')
    {
        $response = [];
        $response["success"] = 0;
        $response["message"] = 'Technical Error!!';

        $clientemail = isset($email_to['client']) ? $email_to['client'] : '';
        $companyemail = isset($email_to['company']) ? $email_to['company'] : '';
        $adminemail = isset($email_to['admin']) ? $email_to['admin'] : '';
        $admin_id = 0;
        if (Auth::check()) {
            $admin_id = Auth::user()->id;
        }

        $payment_action = $mode == 'cancel' ? 'Refund' : 'Refund';
        $payment_case = $mode == 'cancel' ? 'cancel' : 'Refund';
        $booking_status = $mode == 'cancel' ? 'cancelled' : 'Refund';

        //if ($type == '') {
        //$booking = $db->get_row("SELECT * FROM " . $db->prefix . "booking WHERE id='" . $id . "' ");
        $booking = airports_bookings::where("id", $id)->first();


        $companyID = $booking->companyId;
        //$company = "companyId = '" . $companyID . "'";

        $status = $mode == 'cancel' ? 'Cancel Booking' : 'Refund';
        $cstatus = $mode == 'cancel' ? 'Cancel Booking Company' : 'Refund';
        $getstatus = 1;


        // }

//        if ($type == 'hotels') {
//            $booking = $db->get_row("SELECT * FROM " . $db->prefix . "hotel_bookings WHERE id='" . $id . "' ");
//            $btbl = $db->prefix . "hotel_bookings";
//            $tbl = $db->prefix . "hotel_transaction";
//            $company = "hotelID = '" . $booking['hotel_id'] . "'";
//            $companyID = $booking['hotel_id'];
//            $status = 'Cancel Hotel Booking';
//            $cstatus = 'Cancel Hotel Booking Company';
//            $getstatus = 1;
//            $booking_action = "";
//        }
//
//        if ($type == 'hotelsparking') {
//            $booking = $db->get_row("SELECT * FROM " . $db->prefix . "hotel_parking_booking WHERE id='" . $id . "' ");
//            $btbl = $db->prefix . "hotel_parking_booking";
//            $tbl = $db->prefix . "hotel_parking_transaction";
//            $company = "hotelID = '" . $booking['hotel_id'] . "'";
//            $companyID = $booking['hotel_id'];
//            $status = 'Cancel Hotel Parking Booking';
//            $cstatus = 'Cancel Hotel Parking Booking Company';
//            $getstatus = 1;
//            $booking_action = "";
//        }
//
//        if ($type == 'lounges') {
//            $booking = $db->get_row("SELECT * FROM " . $db->prefix . "lounges_bookings WHERE id='" . $id . "' ");
//            $btbl = $db->prefix . "lounges_bookings";
//            $tbl = $db->prefix . "lounges_transaction";
//            $company = "loungeID = '" . $booking['lounge_id'] . "'";
//            $companyID = $booking['lounge_id'];
//            $status = 'Cancel Lounges Booking';
//            $cstatus = 'Cancel Lounges Booking Company';
//            $booking_action = $mode == 'cancel' ? ", booking_action = 'Cancelled'" : ", booking_action = 'Refund'";
//            if ($mode == "cancel") {
//                if ($booking['referenceNo_ext'] != "") {
//                    $getstatus = get_cancel_status($booking['referenceNo_ext']);
//                } else {
//                    $getstatus = "Cancel Not availble..!!";
//                }
//            } else {
//                $getstatus = 1;
//            }
//
//        }

        if ($booking) {


            if ($amt == 'full') {
                $refund = ($booking->booking_amount * 1) - ($booking->discount_amount * 1);
            } else {
                $refund = $amt;
            }
            if ($reason == '00') {
                $reason = 'Not Show';
                $status = 'Cancel Booking Not Show';
                $booking_status = 'Noshow';
                //$booking_action = ", booking_action = 'Noshow'";
            }
            if ($payment_medium == "Payment Gateway") {
                $refundStatus = $this->refundPayment($refund, $booking->referenceNo, $booking->PayerID);
            } else {
                $refundStatus = [];
                $refundStatus["StatusCode"] = 0;
            }


            if ($refundStatus["StatusCode"] == 0) {
                $getstatus = 1;


                if ($getstatus == 1) {


                    $data = [];
                    $data["orderID"] = $booking->id;
                    $data["referenceNo"] = $booking->referenceNo;
                    $data["companyId"] = $booking->companyId;
                    $data["booking_amount"] = $booking->booking_amount;
                    $data["extra_amount"] = $booking->extra_amount;
                    $data["discount_amount"] = $booking->discount_amount;
                    $data["smsfee"] = $booking->smsfee;
                    $data["booking_fee"] = $booking->booking_fee;
                    $data["cancelfee"] = $booking->cancelfee;
                    $data["payable"] = $refund;
                    $data["amount_type"] = 'credit';
                    $data["payment_method"] = '$booking->payment_method';
                    $data["payment_action"] = '$payment_action';
                    $data["payment_case"] = $payment_case;
                    $data["payment_medium"] = $booking_payment_medium;
                    $data["comments"] = $reason;
                    $data["edit_by"] = $admin_id;
                    $data["modifydate"] = date("Y-m-d H:i:s");
                    $data["total_amount"] = $booking->total_amount;

                    $transaction = DB::table('booking_transaction')->insertGetId($data);

                    $trans_id = $transaction;
                    $i = 0;
                    if (!empty($palenty_amount)) {
                        foreach ($palenty_amount as $penalty) {
                            if($penalty==""){
                                $penalty=0;
                            }
                            $d = [];
                            $d["trans_id"] = $trans_id;
                            $d["payment_medium"] = $payment_medium[$i];
                            $d["penalty_amount"] = $penalty;
                            $d["penalty_to"] = $palenty_to[$i];


                            $inserted = DB::table('penalty_details')->insert($d);


//                        $inserted = $db->insert("INSERT INTO " . $db->prefix . "penalty_details set
//
//				trans_id = '" . $trans_id . "',
//				payment_medium = '" . $payment_medium[$i] . "',
//				penalty_amount = '" . $penalty . "',
//				penalty_to = '" . $palenty_to[$i] . "'
//				");
                            $i++;
                        }
                    }


                    if ($inserted) {
                        // $query = $db->update("UPDATE $btbl SET booking_status = '" . $booking_status . "' $booking_action WHERE id = '" . $id . "' ");

                        $dd = [];
                        $dd["booking_status"] = $booking_status;

                        $dd["booking_action"] = "Refund";
                        if ($mode == 'cancel') {
                            $dd["booking_action"] = "Cancelled";
                        }


                        if ($reason == '00') {
                            $dd["booking_action"] = "Noshow";
                        }


                        $query = DB::table('airports_bookings')
                            ->where("id", $id)
                            ->update($dd);

                        $query = 1;
                        if ($query) {
                            $company_email = is_numeric($companyID) ? 'company' : 'parkingzone@gmail.com';


                            $bookData = airports_bookings::getSingleRowById($id);

                            $template_data = [];
                            $template_data["username"] = $bookData->first_name . " " . $bookData->first_name;

                            $template_data["airport"] = $bookData->airport->name;
                            if ($bookData->dterminal) {
                                $template_data["terminal"] = $bookData->dterminal->name;
                            }
                            if ($bookData->rterminal) {
                                $template_data["rterminal"] = $bookData->rterminal->name;
                            }
                            $template_data["days"] = $bookData->no_of_days;
                            $template_data["start_date"] = $bookData->departDate;
                            $template_data["end_date"] = $bookData->returnDate;
                            $template_data["r_flight_no"] = $bookData->returnFlight;
                            $template_data["reg"] = $bookData->registration;
                            $template_data["ref"] = $bookData->referenceNo;
                            $template_data["refund"] = $refund;


                            if ($mode == 'cancel' && !empty($companyemail)) {
                                //notifications($id, $cstatus, $company_email);

                                $email_send = new EmailController();

                                if ($bookData->company) {
                                    $company_email = $bookData->company->company_email;
                                }
                                $email_send->sendEmail($cstatus, $company_email, $template_data);

                                // notifications($id, $cstatus,'ubaid@zafftech.com','company');
                            }
                            if (!empty($adminemail)) {
                                if ($bookData->admin) {
                                    $adminemail = $bookData->admin->email;
                                }
                                // notifications($id, $status, 'admin', '', '', $type);

                                $email_send = new EmailController();
                                $email_send->sendEmail($status, $adminemail, $template_data);
                            }
                            if (!empty($clientemail)) {
                                // notifications($id, $status, $booking['email'], '', '', $type);
                                // notifications($id, $status,'ubaid@zafftech.com','','',$type);
                                $email_send = new EmailController();
                                $email_send->sendEmail($status, $booking['email'], $template_data);
                            }
                            $response["success"] = 1;
                            $response["message"] = 'Booking Successfully ' . ucwords($mode) . '..!!';
                            //$msg = base64_encode('success:Booking Successfully ' . ucwords($mode) . '..!!');
                        } else {
                            //$msg = base64_encode('error:Try again..!!');
                            $response["success"] = 0;
                            $response["message"] = 'Try again..!!';

                        }
                    }
                } else {
                    //$msg = base64_encode('error:' . $getstatus);
                    $response["success"] = 0;
                    $response["message"] = 'Error! Try again..!!';
                }

            } else {
                $response["success"] = 0;
                $response["message"] = $refundStatus["Message"];
            }
            return $response;
        } else {
            //$msg = base64_encode('error:Record not found..!!');
            $response["success"] = 0;
            $response["message"] = 'Record not found..!!';

            return $response;
        }


        return $response;

    }


    function refundPayment($alltotal, $OrderID, $transcationID)
    {
        // global $PayzoneHelper;
        require_once(app_path('library/payzone/includes/payzone_gateway_new.php'));

        $IntegrationType = $PayzoneGateway->getIntegrationType();
        $SecretKey = $PayzoneGateway->getSecretKey();
        $HashMethod = $PayzoneGateway->getHashMethod();


        $CurrencyCode = $PayzoneGateway->getCurrencyCode();
        $respobj = array();
        $queryObj = array();
        $queryObj["Amount"] = $alltotal;
        $queryObj["CurrencyCode"] = $CurrencyCode;
        $queryObj["OrderID"] = $OrderID;
        $queryObj["CrossReference"] = $transcationID;
        $queryObj["OrderDescription"] = "Refund order";
        $queryObj["HashMethod"] = $HashMethod;
        $StringToHash = $PayzoneHelper->generateStringToHashDirect($queryObj["Amount"], $CurrencyCode, $queryObj["OrderID"], $queryObj["OrderDescription"], $SecretKey);
        $ShoppingCartHashDigest = $PayzoneHelper->calculateHashDigest($StringToHash, $SecretKey, $HashMethod);
        $ShoppingCartValidation = $PayzoneHelper->checkIntegrityOfIncomingVariablesDirect("SHOPPING_CART_CHECKOUT", $queryObj, $ShoppingCartHashDigest, $SecretKey);
        $respobj["ShoppingCartHashDigest"] = $ShoppingCartHashDigest;
        if ($ShoppingCartValidation) {
            $queryObj = $PayzoneGateway->buildXHRefund($queryObj["Amount"], $queryObj["OrderID"], $queryObj["CrossReference"]);
            //Process the transaction

            //require_once(__DIR__ . "/includes/gateway/refund_process.php");
            require_once(app_path('library/payzone/includes//gateway/refund_process.php'));

            return $paymentResponse;
            // return json_encode($paymentResponse);//pass the response object back to the JS handler to process
        } else {
            $paymentResponse["Message"] = 'Hash mismatch validation failure';
            $paymentResponse["ErrorMessages"] = true;
            $paymentResponse["StatusCode"] = 100;
            //return json_encode($paymentResponse);
            return $paymentResponse;
        }

    }


    function transferBookingForm($id)
    {

        $html = "<table class=\"table table-bordered responsive\">
	<tbody><tr>
	<td>
	<select name=\"company_id\" id='company_id_pop' class=\"form-control company-bookings\">";

        $companies = Company::all();

        // dd($companies);
        foreach ($companies as $company) {

            $airport = "";
            if ($company->airport) {
                $airport = $company->airport->name;
            }

            $html .= "<option value=\"$company->id\"> $company->name &amp;  --- " . $airport . " </option>";
        }

        $html .= "</select></td></tr><tr><td>
	<input class=\"btn btn-info\"onclick='transferSubmit($id)' name=\"booking_transfer\" value=\"Transfer\"></td></tr></tbody></table>";
        return $html;
    }


    function transferBooking(Request $request)
    {

        $id = $request->input("id");
        $new_cid = $request->input("new_cid");

        $row = airports_bookings::getSingleRowById($id);

        $company_email = "developmentfive1@gmail.com";
        if ($row->company) {
            $company_email = $row->company->company_email;
        }


        $template_data = [];
        $template_data["username"] = $row->first_name . " " . $row->last_name;
        $template_data["ref"] = $row->referenceNo;
        if ($row->company) {
            $template_data["company"] = $row->company->name;
        }


        if ($row->airport) {
            $template_data["airport"] = $row->airport->name;
        }


        $template_data["days"] = $row->no_of_days;
        $template_data["start_date"] = $row->departDate;
        $template_data["end_date"] = $row->returnDate;

        $template_data["r_flight_no"] = $row->returnFlight;
        if ($row->rterminal) {
            $template_data["terminal"] = $row->rterminal->name;
        }
        $template_data["vehicle"] = $row->registration;


        $email_send = new EmailController();
        $email_send->sendEmail("Cancel Booking Company", $company_email, $template_data);


        $d = [];
        $d["companyId"] = $new_cid;
        DB::table('airports_bookings')->where("id", $id)->update($d);


        $template_data = [];
        $template_data["username"] = $row->first_name . " " . $row->last_name;
        $template_data["ref"] = $row->referenceNo;
        if ($row->company) {
            $template_data["company"] = $row->company->name;
        }


        if ($row->airport) {
            $template_data["airport"] = $row->airport->name;
        }


        $template_data["days"] = $row->no_of_days;
        $template_data["carpark"] = "Car Park";
        $template_data["payment_status"] = $row->payment_status;
        $template_data["ptype"] = $row->booked_type;
        $template_data["start_date"] = $row->departDate;
        $template_data["end_date"] = $row->returnDate;
        $template_data["email"] = $row->email;
        $template_data["telephone"] = $row->phone_number;
        $template_data["booktime"] = $row->created_at;
        $template_data["payment_gatway"] = $row->payment_method;
        $template_data["price"] = $row->total_amount;


        $template_data["r_flight_no"] = $row->returnFlight;
        if ($row->rterminal) {
            $template_data["rterminal"] = $row->rterminal->name;
        }
        if ($row->dterminal) {
            $template_data["terminal"] = $row->dterminal->name;
        }
        $template_data["reg"] = $row->registration;
        $template_data["make"] = $row->make;
        $template_data["model"] = $row->model;
        $template_data["color"] = $row->color;
        $template_data["bprice"] = $row->booking_amount;


        $new_company_email = Company::where("id", $new_cid)->first();

//dd($new_company_email);
        $email_send = new EmailController();
        $email_send->sendEmail("Add Booking Company", $new_company_email->company_email, $template_data);


        $template_data["c_parent"] = $new_company_email->name;
        $email_send = new EmailController();
        $email_send->sendEmail("client change company", $row->email, $template_data);


        $html = "<h1>Company Successfully Transfer</h1>";


        return $html;
        // notifications($booking_id, 'Cancel Booking Company',$company_email);

//
//        $query = $db->update("UPDATE " . $db->prefix . "booking SET companyId = '".$new_company_id."'  WHERE id = '" . $booking_id . "' ");
//
//
//        $new_company_email = is_numeric($new_company_id) ? 'company' : 'customerservices@aph.com';
//        notifications($booking_id, 'Add Booking Company', $new_company_email);
//
//
//        $return = notifications($booking_id, 'client change company', $company['email']);


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit = 1;
        $airports = airport::getAll();
        return view("admin.booking.add_booking", ["airports" => $airports, "type" => "edit", "id" => $id, "settings" => $this->_setting, "edit" => $edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $airport_id = $request->input("airport_id");

        $dropdate = $request->input("dep_date");
        $droptime = $request->input("departure_time");
        $pickdate = $request->input("return_date");
        $picktime = $request->input("return_time");


        $dep_date = date('Y-m-d H:i:s', strtotime($dropdate . " " . $droptime));
        $return_date = date('Y-m-d H:i:s', strtotime($pickdate . " " . $picktime));


        $promo = $request->input("promo");
        $first_name = $request->input("first_name");
        $title = $request->input("title");
        $last_name = $request->input("last_name");
        $email = $request->input("email");
        $contact = $request->input("contact");

        $address = $request->input("address");
        $address2 = $request->input("address2");
        $post_code = $request->input("post_code");
        $town = $request->input("town");
        $departure_terminal = $request->input("departure_terminal");
        $return_terminal = $request->input("return_terminal");

        $veh_make = $request->input("veh_make");
        $veh_model = $request->input("veh_model");
        $veh_colour = $request->input("veh_colour");
        $veh_registration = $request->input("veh_registration");
        $transaction_id = $request->input("transaction_id");

        $payment_method = $request->input("payment_method");

        $company_id = $request->input("company_id");
        $parking_type = $request->input("parking_type");
        $discount_amount = $request->input("discount_amount");
        $p_booking_amount = $request->input("p_booking_amount");

        $postalFEE = $request->input("postalFEE");
        $bookingFEE = $request->input("bookingFEE");
        $add_extra = $request->input("add_extra");
        $totalAMOUNT = $request->input("totalAMOUNT");
        $h_totalAMOUNT = $request->input("h_totalAMOUNT");

        $no_of_days = $request->input("no_of_days");
        $smsFEE = $request->input("smsFEE");
        $cancelFEE = $request->input("cancelFEE");
        $passenger = $request->input("passenger");
        $return_flight_no = $request->input("return_flight_no");
        $dept_flight_no = $request->input("dept_flight_no");

//creating customer
        $pass = $this->randomPassword();
        $data = array();
        $data["title"] = $title;
        $data["first_name"] = $first_name;
        $data["last_name"] = $last_name;
        $data["phone_number"] = $contact;
        $data["password"] = md5($pass);
        $data["address"] = $address;
        $data["address2"] = $address2;
        $data["town"] = $town;
        $data["added_on"] = date("Y-m-d H:i:s");
        $data["update_on"] = date("Y-m-d H:i:s");
        $data["email"] = $email;

        $customer_exist = customers::where('email', $request->input('email'))->first();
        if ($customer_exist) {
            $customerData = customers::where('email', $email)
                ->update($data);
            $customer_id = $customer_exist->id;

        } else {

            $customerData = customers::updateOrCreate($data);
            $customer_id = $customerData->id;

        }
//creating customer end
        $ip = request()->ip();
        $data = [];
        $data["airportID"] = $airport_id;
        $data["customerId"] = $customer_id;
        $data["companyId"] = $company_id;
        $data["title"] = $title;
        $data["first_name"] = $first_name;
        $data["last_name"] = $last_name;
        $data["email"] = $email;
        $data["phone_number"] = $contact;
        $data["fulladdress"] = $address;
        $data["address"] = $address;
        $data["address2"] = $address2;
        $data["town"] = $town;
        $data["postal_code"] = $post_code;
        $data["passenger"] = $passenger;
        $data["departDate"] = $dep_date;

        $data["deprTerminal"] = $departure_terminal;
        $data["deptFlight"] = $dept_flight_no;
        $data["returnDate"] = $return_date;
        $data["returnFlight"] = $return_flight_no;
        $data["returnTerminal"] = $return_terminal;
        $data["no_of_days"] = $no_of_days;
        $data["discount_code"] = $promo;
        $data["discount_amount"] = $discount_amount;
        $data["booking_amount"] = $p_booking_amount;
        $data["booking_extra"] = $add_extra;
        $data["smsfee"] = $smsFEE;

        $data["booking_fee"] = $bookingFEE;
        $data["cancelfee"] = $cancelFEE;
        $data["total_amount"] = $totalAMOUNT;
        //$data["leavy_fee"] = $l_fee;
        $data["booked_type"] = $parking_type;

        $data["make"] = $veh_make;
        $data["model"] = $veh_model;
        $data["color"] = $veh_colour;
        $data["registration"] = $veh_registration;
        //$data["traffic_src"]=$_traffic_src;
        $data["user_ip"] = $ip;
        $data["booking_status"] = "completed";

        //dd($data);

        airports_bookings::where("id", $id)->update($data);


        return response(["success" => "1"]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
