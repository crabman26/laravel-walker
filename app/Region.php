<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $fillable = ['Name'];

    public function Municipality(){
    	return $this->belongsTo('App\Municipality');
    }
}
