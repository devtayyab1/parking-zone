<?php



namespace App\Providers;



use App\ref_tracking;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\URL;

use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider

{
    var $msrc = "ORG";

    /**

     * Bootstrap any application services.

     *

     * @return void

     */

    public function boot()

    {



        //https redirect

        URL::forceScheme('https');

        $this->app['request']->server->set('HTTPS', true);





        $this->saveTracking();



        //query log

//        \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {

//            echo '<pre>';

//           // dd($query);

//            print_r([ $query->sql, $query->time]);

//            echo '</pre>';

//        });

    }



    /**

     * Register any application services.

     *

     * @return void

     */

    public function register()

    {

        //

    }





    public function saveTracking()

    {



        $ref_url = URL::previous();

        //dd($ref_url);

        $current_url = URL::full();

        $ip = request()->ip();

        $is_external = $this->isexternal($ref_url);

        //echo $is_external; die();

        //    dd(request()->get("m_source"));

        if ($is_external == true) {

            // if (request()->get("m_source") == "") {

            //     $m_source = "ORG";

            // } else {

            //     $m_source = request()->get("m_source");

            // }

            $m_source = $this->msrc;





            $ref = new ref_tracking();



            $ref->ref_url = $ref_url;

            $ref->current_url = $current_url;

            $ref->user_ip = $ip;

            $ref->m_source = $m_source;

            $ref->created_at = date("Y-m-d");



            if ($is_external == true) {

                $ref->is_internal_url = 1;

            } else {

                $ref->is_internal_url = 0;

            }

            $ref->save();

            if (strpos($current_url, '/affiliate') !== false && 
                strpos($current_url, 'src=por') !== false) {
                redirect()->to('/')->send();
            }



        }







        //echo $ip." | url"; die();

        //setcookie('cookiets_name', "hello testing...iii",time() + (86400 * 30));

        //Cookie::make();

       //echo "<pre>"; print_r($_COOKIE)." | cookie"; die();







    }



    function isexternal($url)

    {

        // $components = parse_url($url);

        // if($components["host"]=="localhost" || $components["host"]=="parkingzone.co.uk" || $components["host"]=="www.parkingzone.co.uk" || $components["host"]=="https://www.parkingzone.co.uk" || $components["host"]=="https://parkingzone.co.uk" ){

        //     return false;

        // }else {

        //     return true;

        // }

        $return = false;

        $qstring = $_SERVER['QUERY_STRING'];
        if (strlen($qstring) > 0) {
            if (strpos($qstring, 'gclid=') !== false) { // ppc
                $this->msrc = 'PPC';
                $return = true;
            } elseif (strpos($qstring, 'utm_source=bing') !== false) { // bing
                $this->msrc = 'BING';
                $return = true;
            } elseif (strpos($qstring, 'src=por') !== false) { // por
                $this->msrc = 'POR';
                $return = true;
            }
			elseif (strpos($qstring, 'src=email') !== false) { // por
                $this->msrc = 'EM';
                $return = true;
            }
        }

        return $return;

       // return !empty($components['host']) && strcasecmp($components['host'], 'parkingzone.co.uk'); // empty host will indicate url like '/relative.php'

    }





}

