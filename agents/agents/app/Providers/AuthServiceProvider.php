<?php

namespace App\Providers;

use App\users_menus;
use App\users_roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("user_auth",function ($user,$permission=null){

            $user_id = Auth::id();
            return users_roles::check_is_exist_role($user_id,$permission);

        });


        Gate::define("menu_auth",function ($user,$menu_name){

            $user_id = Auth::id();
            return users_roles::check_is_exist_menu($user_id,$menu_name);

        });

//        Gate::define("Sales",function ($user){
//
//        });
//
//        Gate::define("Operations",function ($user){
//
//        });
//
//        Gate::define("Marketing",function ($user){
//
//        });
//
//        Gate::define("airport_parking",function ($user){
//
//        });
//
//        Gate::define("Social Marketing",function ($user){
//
//        });
//
//        Gate::define("Developers",function ($user){
//
//        });



        //
    }
}
