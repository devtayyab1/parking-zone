<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class faqs extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ["id", "title", "content", "type"];
}
