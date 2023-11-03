<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class roles extends Model

{        


    protected $fillable = ["id","name","permissions","status"];



    //

    /**

     * The role that belong to the user.

     */

    public function user()

    {

        return $this->hasMany('App\User');

    }

    public function role()

    {

        return $this->hasMany('App\user_roles');

    }

}

