<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['Title','Keyword','Active'];

    public function ad(){
    	return $this->belongsTo('App\Ad');
    }
}
