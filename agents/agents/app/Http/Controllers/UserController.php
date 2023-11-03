<?php

namespace App\Http\Controllers;

use App\roles;
use App\User;
use App\users_menus;
use App\users_roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
    public $pages = ["Dashboard", "Airport Parkings", "Companies", "Plan Setting", "Set Plan", "Booking","Booking List","Operations Invoices","Invoice All", "Add Booking", "Incomplete Booking","Booking Histroy","ParkingZone Detail Commision Reports","Company Commision Reports","Dsp","Dsp View","Price Plan","Price Plan","Set Plan","Airports","Companies","Reports","Print Card","Departure Report","Return Report","Departure and Return Report","Day Wise Report", "Over Night Stay Report","Company Setting","Awards","Setting","Pages", "Reviews", "Faqs", "Subscribers", "Settings", "Email Settings", "Seo Settings", "Footer Settings", "Social Settings", "Analytics Settings", "General Settings", "Email Templates"];



    public $permissions = ["add", "edit", "delete", "view"];

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        set_time_limit(0);
        $users = User::paginate(20);
        if ($request->has("name")) {
            $name = $request->input("name");
            $users = User::where("name", $name)->paginate(20);
        }


        return view("admin.users.list", ["users" => $users]);
    }

    public function register_form()
    {

        $roles = roles::all()->toArray();


        $rolesList = [];
        $rolesList[""] = "Select Role";
        foreach ($roles as $u) {
            $rolesList[$u["id"]] = $u["name"];
        }

        return view("admin.users.create", ["rolesList" => $rolesList, "permissions" => $this->permissions, "pages" => $this->pages]);
    }


    public function edit_register_form($id)
    {

        $user = User::findOrFail($id);

        $roles = roles::all()->toArray();

        $users_permissions  =  users_roles::where("user_id", $user->id)->first();
        $users_hide_pages  =  users_menus::where("user_id", $user->id)->get();
        $role_id=0;
        $userspermissions=[];

        if($users_permissions){

            $role_id =$users_permissions->role_id;
            $userspermissions =explode(",",$users_permissions["permissions"]);
        }

        $users_hide_pages_list = [];
       // dd($users_hide_pages);
        foreach ($users_hide_pages as $u) {

            $users_hide_pages_list[$u->id] = $u->menu_name;
        }

        $rolesList = [];
        $rolesList[""] = "Select Role";
        foreach ($roles as $u) {
            $rolesList[$u["id"]] = $u["name"];
        }


        return view("admin.users.edit", ["rolesList" => $rolesList, "permissions" => $this->permissions, "pages" => $this->pages, "user" => $user,"userspermissions"=>$userspermissions,"users_hide_pages_list"=>$users_hide_pages_list,"role_id"=>$role_id]);
    }



    public function update_user(Request $request,$id){
        $User = User::findOrFail($id);

        $messages = [
            'required' => 'This field is required.'
        ];
        $request->validate([
            'name' => 'required|max:255',
             'role_id'=>'required',
            'email' => 'required|email|max:255'
           

        ], $messages);



        $User->name = $request->input("name");
        $User->email = $request->input("email");
        if(!empty($request->input("password"))) {
            $User->password = Hash::make($request->input("password"));
        }
        $User->active = $request->input("status");
        //$userdata = $User->save();
        if ($User->save()) {
            //print_r($User); die();

            $user_id = $User->id;
            //insert user role and permissions
            $role_id = $request->input("role_id");

            $permissions = "";
            if (count($request->input("permissions")) > 0) {
                $permissions = implode(",", $request->input("permissions"));
            }
            $data = array("user_id" => $user_id, "role_id" => $role_id, "permissions" => $permissions);

            if (count($data) > 0) {
               // DB::table("")->delete()
                users_roles::where('user_id', '=' ,$id)->delete();

                DB::table('users_roles')->insert($data);
            }

            //insert pages or menu
            $data = [];
            if ($request->input("pages")!=""){
             if (count($request->input("pages")) > 0) {
                 foreach ($request->input("pages") as $page) {
                     if ($page != "") {
                         $data[] = array("user_id" => $user_id, "menu_name" => "$page");
                     }
                 }
             }
        }


            if (count($data) > 0) {
                users_menus::where('user_id', '=' ,$id)->delete();
                DB::table('users_menus')->insert($data);
            }

            return redirect(route("user_list"))->with('success', 'Data Update  successfully');

        }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //

        $messages = [
            'required' => 'This field is required.'
        ];
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role_id'=>'required',
            'password' => 'required_with:confirm_password|same:confirm_password',

        ], $messages);

        $User = new User();
        $User->name = $request->input("name");
        $User->email = $request->input("email");
        $User->password = Hash::make($request->input("password"));
        $User->active = $request->input("status");
        //$userdata = $User->save();
        if ($User->save()) {
            //print_r($User); die();
            $data = [];
            $user_id = $User->id;
            //insert user role and permissions
            $role_id = $request->input("role_id");
            $permissions = "";
            if (count($request->input("permissions")) > 0) {
                $permissions = implode(",", $request->input("permissions"));
            }
            $data[] = array("user_id" => $user_id, "role_id" => $role_id, "permissions" => $permissions);

            if (count($data) > 0) {
                DB::table('users_roles')->insert($data);
            }

            //insert pages or menu
            $data = [];
            if ($request->input("pages")!=""){
            if (count($request->input("pages")) > 0) {
                foreach ($request->input("pages") as $page) {
                    if ($page != "") {
                        $data[] = array("user_id" => $user_id, "menu_name" => "$page");
                    }
                }
            }
        }


            if (count($data) > 0) {
                DB::table('users_menus')->insert($data);
            }

        }
        return redirect(route("user_list"))->with('success', 'Data Inserted  successfully');
    }

    public function getRolesPermissions($role_name)
    {

        $data = roles::where("name", $role_name)->get();
        $per_arr = ["add", "edit", "delete", "view"];

        if ($data) {
            if ($data[0]->permissions != null) {
                $permissions = explode(",", $data[0]->permissions);
                foreach ($per_arr as $permission) {
                    //$per_arr[] = $permission;
                    $checked = "";
                    if (in_array($permission, $permissions)) {
                        $checked = "checked='checked'";
                    }

                    echo '<input type="checkbox" name="permissions[]" ' . $checked . ' value="' . $permission . '" >';
                    echo ucfirst($permission) . " <br/>";
                }
            }
        }
        //return response()->json($per_arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\airport $airport
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //

        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Information Deleted successfully');

    }

}
